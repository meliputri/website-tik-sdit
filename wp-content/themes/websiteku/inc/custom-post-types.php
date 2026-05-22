<?php
/**
 * Custom Post Type: Materi TIK
 * 
 * Memungkinkan pengelolaan materi dari wp-admin
 * 
 * @package Websiteku
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type: Materi
 */
function websiteku_register_materi_cpt()
{
    $labels = array(
        'name' => 'Materi TIK',
        'singular_name' => 'Materi',
        'menu_name' => 'Materi TIK',
        'name_admin_bar' => 'Materi',
        'add_new' => 'Tambah Baru',
        'add_new_item' => 'Tambah Materi Baru',
        'new_item' => 'Materi Baru',
        'edit_item' => 'Edit Materi',
        'view_item' => 'Lihat Materi',
        'all_items' => 'Semua Materi',
        'search_items' => 'Cari Materi',
        'not_found' => 'Materi tidak ditemukan',
        'not_found_in_trash' => 'Tidak ada materi di Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'materi'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );

    register_post_type('materi', $args);
}
add_action('init', 'websiteku_register_materi_cpt');

/**
 * Add Meta Boxes for Materi
 */
function websiteku_materi_meta_boxes()
{
    add_meta_box(
        'materi_details',
        'Detail Materi',
        'websiteku_materi_details_callback',
        'materi',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'websiteku_materi_meta_boxes');

/**
 * Meta Box Callback
 */
function websiteku_materi_details_callback($post)
{
    wp_nonce_field('websiteku_materi_nonce', 'materi_nonce');

    $icon = get_post_meta($post->ID, '_materi_icon', true);
    $bab = get_post_meta($post->ID, '_materi_bab', true);
    $kelas = get_post_meta($post->ID, '_materi_kelas', true) ?: '1';
    $tp = get_post_meta($post->ID, '_materi_tp', true);
    $video_url = get_post_meta($post->ID, '_materi_video_url', true);
    $quiz_id = get_post_meta($post->ID, '_materi_quiz_id', true);
    $pdf_url = get_post_meta($post->ID, '_materi_pdf_url', true);
    $is_active = get_post_meta($post->ID, '_materi_active', true);
    $tp_referensi = websiteku_get_tp_referensi_kelas();

    // Default aktif untuk materi baru
    if ($is_active === '' && get_post_status($post->ID) === 'auto-draft') {
        $is_active = '1';
    }

    ?>
    <style>
        .materi-meta-row {
            margin-bottom: 15px;
        }

        .materi-meta-row label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .materi-meta-row input[type="text"],
        .materi-meta-row input[type="number"],
        .materi-meta-row select {
            width: 100%;
            max-width: 400px;
            padding: 8px;
        }

        .materi-meta-row .description {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }

        .icon-preview {
            font-size: 2rem;
            margin-left: 10px;
        }
    </style>

    <div class="materi-meta-row">
        <label for="materi_kelas">Kelas</label>
        <select id="materi_kelas" name="materi_kelas">
            <?php foreach (websiteku_get_kelas_options() as $val => $label): ?>
                <option value="<?php echo esc_attr($val); ?>" <?php selected($kelas, $val); ?>><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
        </select>
        <p class="description">Materi ditampilkan sesuai kelas dan filter di halaman beranda.</p>
    </div>

    <div class="materi-meta-row">
        <label for="materi_bab">Nomor Bab</label>
        <input type="number" id="materi_bab" name="materi_bab" value="<?php echo esc_attr($bab); ?>" min="1" max="99">
        <p class="description">Contoh: 1, 2, 3, dst.</p>
    </div>

    <div class="materi-meta-row">
        <label for="materi_tp">Tujuan Pembelajaran (TP)</label>
        <textarea id="materi_tp" name="materi_tp" rows="6" class="large-text"
            placeholder="Satu baris = satu TP&#10;Contoh: Mengenal perangkat komputer di sekolah."><?php echo esc_textarea($tp); ?></textarea>
        <p class="description">Sesuaikan dengan TP Informatika/TIK per kelas. Satu TP per baris.</p>
        <div id="materi-tp-referensi" class="materi-tp-referensi-box" style="background:#f0f6f0;padding:12px;border-radius:8px;margin-top:8px;">
            <strong>📋 Referensi TP Kelas <span id="tp-ref-kelas"><?php echo esc_html($kelas); ?></span>:</strong>
            <ul id="tp-ref-list" style="margin:8px 0 0 18px;">
                <?php
                $ref = $tp_referensi[$kelas] ?? array();
                foreach ($ref as $r) {
                    echo '<li>' . esc_html($r) . '</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="materi-meta-row">
        <label for="materi_video_url">Video Animasi Pembelajaran (URL)</label>
        <input type="url" id="materi_video_url" name="materi_video_url" value="<?php echo esc_url($video_url); ?>"
            class="large-text" placeholder="https://www.youtube.com/watch?v=... atau Vimeo">
        <p class="description">Link YouTube/Vimeo untuk video animasi pembelajaran. Akan ditampilkan di halaman materi.</p>
    </div>

    <div class="materi-meta-row">
        <label for="materi_icon">Icon (Font Awesome)</label>
        <select id="materi_icon" name="materi_icon">
            <option value="fa-desktop" <?php selected($icon, 'fa-desktop'); ?>>Desktop/Komputer</option>
            <option value="fa-keyboard" <?php selected($icon, 'fa-keyboard'); ?>>Keyboard</option>
            <option value="fa-mouse" <?php selected($icon, 'fa-mouse'); ?>>Mouse</option>
            <option value="fa-compact-disc" <?php selected($icon, 'fa-compact-disc'); ?>>CD/Software</option>
            <option value="fa-globe" <?php selected($icon, 'fa-globe'); ?>>Internet/Globe</option>
            <option value="fa-shield-alt" <?php selected($icon, 'fa-shield-alt'); ?>>Security/Shield</option>
            <option value="fa-folder" <?php selected($icon, 'fa-folder'); ?>>Folder</option>
            <option value="fa-file" <?php selected($icon, 'fa-file'); ?>>File</option>
            <option value="fa-code" <?php selected($icon, 'fa-code'); ?>>Code</option>
            <option value="fa-database" <?php selected($icon, 'fa-database'); ?>>Database</option>
            <option value="fa-network-wired" <?php selected($icon, 'fa-network-wired'); ?>>Network</option>
            <option value="fa-wifi" <?php selected($icon, 'fa-wifi'); ?>>WiFi</option>
            <option value="fa-microchip" <?php selected($icon, 'fa-microchip'); ?>>Chip/Processor</option>
            <option value="fa-hdd" <?php selected($icon, 'fa-hdd'); ?>>Hard Disk</option>
            <option value="fa-print" <?php selected($icon, 'fa-print'); ?>>Printer</option>
            <option value="fa-book" <?php selected($icon, 'fa-book'); ?>>Book</option>
        </select>
        <span class="icon-preview"><i class="fas <?php echo esc_attr($icon ?: 'fa-desktop'); ?>"></i></span>
        <p class="description">Pilih icon Font Awesome untuk materi ini.</p>
    </div>

    <div class="materi-meta-row">
        <label for="materi_quiz_id">Quiz ID</label>
        <select id="materi_quiz_id" name="materi_quiz_id">
            <option value="">-- Pilih Quiz --</option>
            <?php
            // Get quizzes from Quiz CPT
            $quiz_posts = get_posts(array(
                'post_type' => 'quiz',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            ));
            foreach ($quiz_posts as $quiz_post):
                $q_id = get_post_meta($quiz_post->ID, '_quiz_id', true);
                if ($q_id):
                    ?>
                    <option value="<?php echo esc_attr($q_id); ?>" <?php selected($quiz_id, $q_id); ?>>
                        <?php echo esc_html($quiz_post->post_title); ?></option>
                <?php
                endif;
            endforeach;
            ?>
        </select>
        <p class="description">Pilih quiz yang terkait dengan materi ini. Buat quiz di menu <a
                href="<?php echo admin_url('edit.php?post_type=quiz'); ?>">Quiz TIK</a> terlebih dahulu.</p>
    </div>

    <div class="materi-meta-row">
        <label for="materi_pdf_url">File PDF</label>
        <input type="text" id="materi_pdf_url" name="materi_pdf_url" value="<?php echo esc_attr($pdf_url); ?>"
            placeholder="URL file PDF">
        <button type="button" class="button" id="upload_pdf_button">Upload PDF</button>
        <p class="description">URL file PDF materi atau klik Upload untuk mengunggah file baru.</p>
    </div>

    <div class="materi-meta-row">
        <label>
            <input type="checkbox" name="materi_active" value="1" <?php checked($is_active, '1'); ?>>
            Materi Aktif (tampilkan di website)
        </label>
    </div>

    <script>
        var tpReferensi = <?php echo wp_json_encode($tp_referensi); ?>;

        jQuery(document).ready(function ($) {
            function updateTpReferensi() {
                var k = $('#materi_kelas').val();
                $('#tp-ref-kelas').text(k);
                var list = tpReferensi[k] || [];
                var html = '';
                list.forEach(function (item) {
                    html += '<li>' + item + '</li>';
                });
                $('#tp-ref-list').html(html || '<li>Tidak ada referensi</li>');
            }
            $('#materi_kelas').on('change', updateTpReferensi);

            $('#materi_icon').on('change', function () {
                $('.icon-preview i').attr('class', 'fas ' + ($(this).val() || 'fa-desktop'));
            });

            // Media uploader for PDF
            $('#upload_pdf_button').click(function (e) {
                e.preventDefault();
                var mediaUploader = wp.media({
                    title: 'Pilih File PDF',
                    button: { text: 'Gunakan File Ini' },
                    library: { type: 'application/pdf' },
                    multiple: false
                });

                mediaUploader.on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#materi_pdf_url').val(attachment.url);
                });

                mediaUploader.open();
            });
        });
    </script>
    <?php
}

/**
 * Save Meta Box Data
 */
function websiteku_save_materi_meta($post_id)
{
    // Security checks
    if (!isset($_POST['materi_nonce']) || !wp_verify_nonce($_POST['materi_nonce'], 'websiteku_materi_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save fields
    $fields = array(
        'materi_bab' => '_materi_bab',
        'materi_kelas' => '_materi_kelas',
        'materi_icon' => '_materi_icon',
        'materi_quiz_id' => '_materi_quiz_id',
        'materi_pdf_url' => '_materi_pdf_url',
        'materi_video_url' => '_materi_video_url',
    );

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            if ($field === 'materi_video_url' || $field === 'materi_pdf_url') {
                update_post_meta($post_id, $meta_key, esc_url_raw($_POST[$field]));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
            }
        }
    }

    if (isset($_POST['materi_tp'])) {
        update_post_meta($post_id, '_materi_tp', sanitize_textarea_field($_POST['materi_tp']));
    }

    // Checkbox field
    $is_active = isset($_POST['materi_active']) ? '1' : '0';
    update_post_meta($post_id, '_materi_active', $is_active);
}
add_action('save_post_materi', 'websiteku_save_materi_meta');

/**
 * Enqueue media uploader
 */
function websiteku_materi_admin_scripts($hook)
{
    global $post_type;
    if ($post_type === 'materi' && in_array($hook, array('post.php', 'post-new.php'))) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'websiteku_materi_admin_scripts');

/**
 * Add custom columns to Materi list
 */
function websiteku_materi_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['materi_kelas'] = 'Kelas';
    $new_columns['materi_bab'] = 'Bab';
    $new_columns['materi_video'] = 'Video';
    $new_columns['materi_icon'] = 'Icon';
    $new_columns['materi_quiz'] = 'Quiz';
    $new_columns['materi_active'] = 'Status';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_materi_posts_columns', 'websiteku_materi_columns');

/**
 * Display custom column content
 */
function websiteku_materi_column_content($column, $post_id)
{
    switch ($column) {
        case 'materi_kelas':
            $kelas = get_post_meta($post_id, '_materi_kelas', true);
            echo $kelas ? esc_html(websiteku_get_kelas_options()[$kelas] ?? 'Kelas ' . $kelas) : '-';
            break;
        case 'materi_bab':
            $bab = get_post_meta($post_id, '_materi_bab', true);
            echo $bab ? 'Bab ' . esc_html($bab) : '-';
            break;
        case 'materi_video':
            $video = get_post_meta($post_id, '_materi_video_url', true);
            echo $video ? '🎬 Ya' : '—';
            break;
        case 'materi_icon':
            $icon = get_post_meta($post_id, '_materi_icon', true);
            echo '<span style="font-size: 1.5rem;">' . esc_html($icon ?: '📚') . '</span>';
            break;
        case 'materi_quiz':
            $quiz = get_post_meta($post_id, '_materi_quiz_id', true);
            echo $quiz ? '✅ ' . esc_html($quiz) : '❌ Tidak ada';
            break;
        case 'materi_active':
            $active = get_post_meta($post_id, '_materi_active', true);
            echo $active === '1' ? '<span style="color: green;">✅ Aktif</span>' : '<span style="color: #999;">⏸️ Tidak aktif</span>';
            break;
    }
}
add_action('manage_materi_posts_custom_column', 'websiteku_materi_column_content', 10, 2);

/**
 * Make columns sortable
 */
function websiteku_materi_sortable_columns($columns)
{
    $columns['materi_bab'] = 'materi_bab';
    return $columns;
}
add_filter('manage_edit-materi_sortable_columns', 'websiteku_materi_sortable_columns');

/**
 * Helper function to get all materi
 * Falls back to all published materi if none are marked active
 */
function websiteku_get_materi($args = array())
{
    $defaults = array(
        'post_type' => 'materi',
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num',
        'meta_key' => '_materi_bab',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_materi_active',
                'value' => '1',
                'compare' => '='
            )
        )
    );

    $args = wp_parse_args($args, $defaults);
    $query = new WP_Query($args);

    // Fallback: jika tidak ada materi aktif, tampilkan semua materi yang published
    if (!$query->have_posts()) {
        $fallback_args = array(
            'post_type'      => 'materi',
            'posts_per_page' => -1,
            'orderby'        => 'meta_value_num',
            'meta_key'       => '_materi_bab',
            'order'          => 'ASC',
            'post_status'    => 'publish',
        );
        $fallback_args = wp_parse_args($fallback_args, array());
        $query = new WP_Query($fallback_args);
    }

    return $query;
}
