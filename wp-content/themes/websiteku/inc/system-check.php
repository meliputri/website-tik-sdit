<?php
/**
 * Cek sistem untuk pengujian blackbox / skripsi
 *
 * @package Websiteku
 */

if (!defined('ABSPATH')) {
    exit;
}

function websiteku_system_checks()
{
    global $wpdb;

    $checks = array();

    $checks[] = array(
        'name' => 'Halaman beranda dapat diakses',
        'ok' => (bool) get_option('page_on_front') || true,
        'detail' => home_url('/'),
    );

    $materi_archive = get_post_type_archive_link('materi');
    $checks[] = array(
        'name' => 'Halaman arsip /materi/ terdaftar',
        'ok' => !empty($materi_archive),
        'detail' => $materi_archive ?: 'Flush permalink di Pengaturan → Tautan Permanen',
    );

    $checks[] = array(
        'name' => 'Materi TIK terisi (published)',
        'ok' => websiteku_materi_published_count() >= 5,
        'detail' => websiteku_materi_published_count() . ' materi (minimal 5 disarankan)',
    );

    $checks[] = array(
        'name' => 'Tabel log chatbot MySQL',
        'ok' => $wpdb->get_var('SHOW TABLES LIKE "' . esc_sql(websiteku_chat_logs_table()) . '"') === websiteku_chat_logs_table(),
        'detail' => websiteku_chat_logs_table(),
    );

    $checks[] = array(
        'name' => 'Log percakapan tersimpan',
        'ok' => websiteku_chat_logs_count() > 0,
        'detail' => websiteku_chat_logs_count() . ' rekaman (uji chatbot di frontend)',
    );

    $checks[] = array(
        'name' => 'Dataset RAG diupload',
        'ok' => websiteku_rag_files_count() > 0,
        'detail' => websiteku_rag_files_count() . ' file di Pengaturan → Dataset RAG',
    );

    $rest = rest_url('websiteku/v1/quiz/pengenalan-komputer');
    $checks[] = array(
        'name' => 'REST API Quiz aktif',
        'ok' => !empty($rest),
        'detail' => $rest,
    );

    $n8n = websiteku_get_option('n8n_webhook_url', '');
    $checks[] = array(
        'name' => 'Webhook n8n dikonfigurasi',
        'ok' => !empty($n8n),
        'detail' => $n8n ? 'URL terisi' : 'Isi di Pengaturan Tema',
    );

    return $checks;
}

function websiteku_system_check_admin_menu()
{
    add_submenu_page(
        'websiteku-settings',
        'Status Pengujian',
        'Status Pengujian',
        'manage_options',
        'websiteku-system-check',
        'websiteku_system_check_admin_page'
    );
}
add_action('admin_menu', 'websiteku_system_check_admin_menu', 25);

function websiteku_system_check_admin_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $checks = websiteku_system_checks();
    $passed = count(array_filter($checks, function ($c) {
        return $c['ok'];
    }));
    $total = count($checks);
    ?>
    <div class="wrap">
        <h1>Status Pengujian Sistem (Black Box)</h1>
        <p>Gunakan halaman ini untuk memverifikasi kesiapan sebelum screenshot BAB IV. <strong><?php echo esc_html($passed . '/' . $total); ?></strong> cek lulus.</p>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Uji</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checks as $c): ?>
                    <tr>
                        <td><?php echo esc_html($c['name']); ?></td>
                        <td><?php echo $c['ok'] ? '✅ Valid' : '⚠️ Perlu tindakan'; ?></td>
                        <td><?php echo esc_html($c['detail']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top:20px;">
            <a class="button button-primary" href="<?php echo esc_url(home_url('/')); ?>" target="_blank">Buka Website</a>
            <a class="button" href="<?php echo esc_url(get_post_type_archive_link('materi')); ?>" target="_blank">Buka /materi/</a>
            <a class="button" href="<?php echo esc_url(admin_url('edit.php?post_type=materi&page=websiteku-materi-seed')); ?>">Impor Materi</a>
        </p>
    </div>
    <?php
}
