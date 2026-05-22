<?php
/**
 * Log interaksi chatbot ke MySQL (sesuai proposal skripsi BAB IV)
 *
 * @package Websiteku
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WEBSITEKU_CHAT_LOGS_DB_VERSION', '1.0');

/**
 * Nama tabel log.
 */
function websiteku_chat_logs_table()
{
    global $wpdb;
    return $wpdb->prefix . 'websiteku_chat_logs';
}

/**
 * Buat / upgrade tabel.
 */
function websiteku_chat_logs_install()
{
    global $wpdb;
    $table = websiteku_chat_logs_table();
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        session_id varchar(64) NOT NULL DEFAULT '',
        kelas varchar(4) NOT NULL DEFAULT '',
        user_message text NOT NULL,
        bot_answer longtext NOT NULL,
        source varchar(32) NOT NULL DEFAULT 'rule',
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY session_id (session_id),
        KEY created_at (created_at),
        KEY kelas (kelas)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    update_option('websiteku_chat_logs_db_version', WEBSITEKU_CHAT_LOGS_DB_VERSION);
}

add_action('after_switch_theme', 'websiteku_chat_logs_install');
add_action('admin_init', function () {
    if (get_option('websiteku_chat_logs_db_version') !== WEBSITEKU_CHAT_LOGS_DB_VERSION) {
        websiteku_chat_logs_install();
    }
});

/**
 * Simpan log percakapan.
 */
function websiteku_save_chat_log($session_id, $kelas, $user_message, $bot_answer, $source = 'rule')
{
    global $wpdb;

    $allowed_sources = array('n8n', 'rule', 'materi', 'tp', 'fallback', 'error');
    if (!in_array($source, $allowed_sources, true)) {
        $source = 'rule';
    }

    $wpdb->insert(
        websiteku_chat_logs_table(),
        array(
            'session_id' => sanitize_text_field(substr($session_id, 0, 64)),
            'kelas' => sanitize_text_field(substr((string) $kelas, 0, 4)),
            'user_message' => sanitize_textarea_field($user_message),
            'bot_answer' => sanitize_textarea_field($bot_answer),
            'source' => $source,
            'created_at' => current_time('mysql'),
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );

    return $wpdb->insert_id;
}

/**
 * AJAX: log dari frontend (rule-based / materi / fallback).
 */
function websiteku_ajax_log_chat()
{
    check_ajax_referer('websiteku_chat_log', 'nonce');

    $user_message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    $bot_answer = isset($_POST['answer']) ? sanitize_textarea_field(wp_unslash($_POST['answer'])) : '';
    $source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'rule';
    $kelas = isset($_POST['kelas']) ? sanitize_text_field($_POST['kelas']) : '';

    if ($user_message === '' || $bot_answer === '') {
        wp_send_json_error(array('message' => 'Data log tidak lengkap'));
    }

    $session_id = isset($_COOKIE['websiteku_chat_session'])
        ? sanitize_text_field($_COOKIE['websiteku_chat_session'])
        : wp_generate_uuid4();

    if (!isset($_COOKIE['websiteku_chat_session'])) {
        setcookie('websiteku_chat_session', $session_id, time() + (86400 * 30), '/');
    }

    $id = websiteku_save_chat_log($session_id, $kelas, $user_message, $bot_answer, $source);

    wp_send_json_success(array('log_id' => $id));
}
add_action('wp_ajax_websiteku_log_chat', 'websiteku_ajax_log_chat');
add_action('wp_ajax_nopriv_websiteku_log_chat', 'websiteku_ajax_log_chat');

/**
 * Menu admin log chatbot.
 */
function websiteku_chat_logs_admin_menu()
{
    add_submenu_page(
        'edit.php?post_type=chatbot_qa',
        'Log Percakapan Chatbot',
        'Log Percakapan',
        'manage_options',
        'websiteku-chat-logs',
        'websiteku_chat_logs_admin_page'
    );
}
add_action('admin_menu', 'websiteku_chat_logs_admin_menu');

/**
 * Halaman daftar log.
 */
function websiteku_chat_logs_admin_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;
    $table = websiteku_chat_logs_table();

    if (isset($_POST['websiteku_clear_logs']) && check_admin_referer('websiteku_clear_chat_logs')) {
        $wpdb->query("TRUNCATE TABLE {$table}");
        echo '<div class="notice notice-success"><p>Log percakapan berhasil dikosongkan.</p></div>';
    }

    $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
    $logs = $wpdb->get_results(
        "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT 100",
        ARRAY_A
    );
    ?>
    <div class="wrap">
        <h1>Log Percakapan Chatbot (MySQL)</h1>
        <p>Interaksi pengguna–chatbot disimpan di tabel <code><?php echo esc_html($table); ?></code> — sesuai proposal BAB IV.</p>
        <p><strong>Total rekaman:</strong> <?php echo esc_html(number_format_i18n($total)); ?></p>

        <form method="post" style="margin: 15px 0;" onsubmit="return confirm('Hapus semua log?');">
            <?php wp_nonce_field('websiteku_clear_chat_logs'); ?>
            <button type="submit" name="websiteku_clear_logs" class="button">Kosongkan Log</button>
            <a href="<?php echo esc_url(admin_url('admin.php?page=websiteku-export-chat-logs')); ?>" class="button">Export CSV</a>
        </form>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Waktu</th>
                    <th>Session</th>
                    <th>Kelas</th>
                    <th>Sumber</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="7">Belum ada log. Uji chatbot di website frontend.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo esc_html($log['id']); ?></td>
                            <td><?php echo esc_html($log['created_at']); ?></td>
                            <td><code><?php echo esc_html(substr($log['session_id'], 0, 12)); ?>…</code></td>
                            <td><?php echo $log['kelas'] ? esc_html('Kelas ' . $log['kelas']) : '—'; ?></td>
                            <td><?php echo esc_html($log['source']); ?></td>
                            <td><?php echo esc_html(wp_trim_words($log['user_message'], 12)); ?></td>
                            <td><?php echo esc_html(wp_trim_words($log['bot_answer'], 12)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Export CSV log (admin).
 */
function websiteku_chat_logs_export_page()
{
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    global $wpdb;
    $table = websiteku_chat_logs_table();
    $logs = $wpdb->get_results("SELECT * FROM {$table} ORDER BY created_at DESC", ARRAY_A);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=chatbot-logs-' . date('Y-m-d') . '.csv');

    $out = fopen('php://output', 'w');
    fputcsv($out, array('id', 'created_at', 'session_id', 'kelas', 'source', 'user_message', 'bot_answer'));
    foreach ($logs as $log) {
        fputcsv($out, array(
            $log['id'],
            $log['created_at'],
            $log['session_id'],
            $log['kelas'],
            $log['source'],
            $log['user_message'],
            $log['bot_answer'],
        ));
    }
    fclose($out);
    exit;
}

add_action('admin_menu', function () {
    add_submenu_page(
        null,
        'Export Log',
        'Export',
        'manage_options',
        'websiteku-export-chat-logs',
        'websiteku_chat_logs_export_page'
    );
});

/**
 * Hitung log untuk status pengujian.
 */
function websiteku_chat_logs_count()
{
    global $wpdb;
    return (int) $wpdb->get_var('SELECT COUNT(*) FROM ' . websiteku_chat_logs_table());
}
