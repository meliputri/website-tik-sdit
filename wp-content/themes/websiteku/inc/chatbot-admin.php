<?php
/**
 * Custom Post Type: Chatbot Q&A
 * 
 * Kelola pertanyaan-jawaban chatbot dari wp-admin
 * 
 * @package Websiteku
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type: Chatbot QA
 */
function websiteku_register_chatbot_cpt()
{
    $labels = array(
        'name' => 'Chatbot Q&A',
        'singular_name' => 'Q&A',
        'menu_name' => 'Chatbot Q&A',
        'add_new' => 'Tambah Q&A',
        'add_new_item' => 'Tambah Q&A Baru',
        'edit_item' => 'Edit Q&A',
        'view_item' => 'Lihat Q&A',
        'all_items' => 'Semua Q&A',
        'search_items' => 'Cari Q&A',
        'not_found' => 'Q&A tidak ditemukan',
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-format-chat',
        'supports' => array('title'),
        'show_in_rest' => true,
    );

    register_post_type('chatbot_qa', $args);
}
add_action('init', 'websiteku_register_chatbot_cpt');

/**
 * Add Meta Boxes
 */
function websiteku_chatbot_meta_boxes()
{
    add_meta_box(
        'chatbot_qa_details',
        'Detail Q&A',
        'websiteku_chatbot_details_callback',
        'chatbot_qa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'websiteku_chatbot_meta_boxes');

/**
 * Meta Box Callback
 */
function websiteku_chatbot_details_callback($post)
{
    wp_nonce_field('websiteku_chatbot_nonce', 'chatbot_nonce');

    $answer = get_post_meta($post->ID, '_chatbot_answer', true);
    $keywords = get_post_meta($post->ID, '_chatbot_keywords', true);
    $category = get_post_meta($post->ID, '_chatbot_category', true);
    $kelas = get_post_meta($post->ID, '_chatbot_kelas', true);

    ?>
    <style>
        .chatbot-meta-row {
            margin-bottom: 20px;
        }

        .chatbot-meta-row label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .chatbot-meta-row input[type="text"],
        .chatbot-meta-row textarea,
        .chatbot-meta-row select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
        }

        .chatbot-meta-row textarea {
            min-height: 150px;
        }

        .chatbot-meta-row .description {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }

        .chatbot-preview {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .chatbot-preview-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }
    </style>

    <div class="chatbot-meta-row">
        <label for="chatbot_kelas">Kelas (opsional)</label>
        <select id="chatbot_kelas" name="chatbot_kelas">
            <option value="" <?php selected($kelas, ''); ?>>Semua Kelas</option>
            <?php foreach (websiteku_get_kelas_options() as $val => $label): ?>
                <option value="<?php echo esc_attr($val); ?>" <?php selected($kelas, $val); ?>><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
        </select>
        <p class="description">Batasi Q&amp;A ini untuk kelas tertentu (kosongkan untuk semua kelas).</p>
    </div>

    <div class="chatbot-meta-row">
        <label for="chatbot_category">Kategori</label>
        <select id="chatbot_category" name="chatbot_category">
            <option value="umum" <?php selected($category, 'umum'); ?>>Umum</option>
            <option value="komputer" <?php selected($category, 'komputer'); ?>>Pengenalan Komputer</option>
            <option value="hardware" <?php selected($category, 'hardware'); ?>>Hardware</option>
            <option value="software" <?php selected($category, 'software'); ?>>Software</option>
            <option value="internet" <?php selected($category, 'internet'); ?>>Internet</option>
            <option value="keamanan" <?php selected($category, 'keamanan'); ?>>Keamanan Digital</option>
        </select>
        <p class="description">Pilih kategori untuk mengelompokkan Q&A</p>
    </div>

    <div class="chatbot-meta-row">
        <label for="chatbot_answer">Jawaban</label>
        <textarea id="chatbot_answer" name="chatbot_answer"
            placeholder="Masukkan jawaban untuk pertanyaan ini..."><?php echo esc_textarea($answer); ?></textarea>
        <p class="description">Jawaban yang akan ditampilkan oleh chatbot. Bisa menggunakan emoji dan baris baru.</p>
    </div>

    <div class="chatbot-meta-row">
        <label for="chatbot_keywords">Kata Kunci (Keywords)</label>
        <input type="text" id="chatbot_keywords" name="chatbot_keywords" value="<?php echo esc_attr($keywords); ?>"
            placeholder="komputer, pc, laptop, desktop">
        <p class="description">Kata kunci tambahan yang bisa memicu jawaban ini (pisahkan dengan koma)</p>
    </div>

    <div class="chatbot-preview">
        <div class="chatbot-preview-label">📱 Preview Chat:</div>
        <div style="background: #DCF8C6; padding: 10px; border-radius: 8px; margin-bottom: 8px; max-width: 80%;">
            <strong>User:</strong>
            <?php echo esc_html($post->post_title ?: 'Pertanyaan...'); ?>
        </div>
        <div
            style="background: white; padding: 10px; border-radius: 8px; max-width: 80%; margin-left: auto; border: 1px solid #ddd;">
            <strong>🤖 Bot:</strong>
            <?php echo nl2br(esc_html($answer ?: 'Jawaban akan muncul di sini...')); ?>
        </div>
    </div>
    <?php
}

/**
 * Save Meta Box Data
 */
function websiteku_save_chatbot_meta($post_id)
{
    if (!isset($_POST['chatbot_nonce']) || !wp_verify_nonce($_POST['chatbot_nonce'], 'websiteku_chatbot_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['chatbot_answer'])) {
        update_post_meta($post_id, '_chatbot_answer', sanitize_textarea_field($_POST['chatbot_answer']));
    }

    if (isset($_POST['chatbot_keywords'])) {
        update_post_meta($post_id, '_chatbot_keywords', sanitize_text_field($_POST['chatbot_keywords']));
    }

    if (isset($_POST['chatbot_category'])) {
        update_post_meta($post_id, '_chatbot_category', sanitize_text_field($_POST['chatbot_category']));
    }

    if (isset($_POST['chatbot_kelas'])) {
        update_post_meta($post_id, '_chatbot_kelas', sanitize_text_field($_POST['chatbot_kelas']));
    }
}
add_action('save_post_chatbot_qa', 'websiteku_save_chatbot_meta');

/**
 * Add custom columns
 */
function websiteku_chatbot_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'Pertanyaan';
    $new_columns['chatbot_answer'] = 'Jawaban';
    $new_columns['chatbot_category'] = 'Kategori';
    $new_columns['chatbot_keywords'] = 'Keywords';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_chatbot_qa_posts_columns', 'websiteku_chatbot_columns');

/**
 * Display column content
 */
function websiteku_chatbot_column_content($column, $post_id)
{
    switch ($column) {
        case 'chatbot_answer':
            $answer = get_post_meta($post_id, '_chatbot_answer', true);
            echo esc_html(wp_trim_words($answer, 10));
            break;
        case 'chatbot_category':
            $category = get_post_meta($post_id, '_chatbot_category', true);
            $categories = [
                'umum' => '📌 Umum',
                'komputer' => '🖥️ Komputer',
                'hardware' => '⌨️ Hardware',
                'software' => '💿 Software',
                'internet' => '🌐 Internet',
                'keamanan' => '🔒 Keamanan',
            ];
            echo isset($categories[$category]) ? $categories[$category] : '📌 Umum';
            break;
        case 'chatbot_keywords':
            $keywords = get_post_meta($post_id, '_chatbot_keywords', true);
            if ($keywords) {
                $tags = explode(',', $keywords);
                foreach (array_slice($tags, 0, 3) as $tag) {
                    echo '<span style="background: #e0e0e0; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-right: 3px;">' . esc_html(trim($tag)) . '</span>';
                }
                if (count($tags) > 3) {
                    echo '<span style="color: #888;">+' . (count($tags) - 3) . '</span>';
                }
            }
            break;
    }
}
add_action('manage_chatbot_qa_posts_custom_column', 'websiteku_chatbot_column_content', 10, 2);

/**
 * Generate Chatbot Data JSON for frontend
 */
function websiteku_get_chatbot_data_from_db()
{
    $qa_query = new WP_Query([
        'post_type' => 'chatbot_qa',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);

    $data = [];

    if ($qa_query->have_posts()) {
        while ($qa_query->have_posts()) {
            $qa_query->the_post();
            $question = strtolower(get_the_title());
            $answer = get_post_meta(get_the_ID(), '_chatbot_answer', true);
            $keywords_str = get_post_meta(get_the_ID(), '_chatbot_keywords', true);
            $qa_kelas = get_post_meta(get_the_ID(), '_chatbot_kelas', true);

            $keywords = [];
            if ($keywords_str) {
                $keywords = array_map('trim', explode(',', strtolower($keywords_str)));
            }
            if ($qa_kelas) {
                $keywords[] = 'kelas ' . $qa_kelas;
                $keywords[] = 'kls ' . $qa_kelas;
            }

            $data[$question] = [
                'answer' => $answer,
                'keywords' => $keywords,
                'kelas' => $qa_kelas,
            ];
        }
        wp_reset_postdata();
    }

    return $data;
}

/**
 * Output chatbot data as inline script
 */
function websiteku_output_chatbot_db_data()
{
    $db_data = websiteku_get_chatbot_data_from_db();

    if (!empty($db_data)) {
        echo '<script>
            // Merge database chatbot data with default data
            if (typeof ChatbotData !== "undefined") {
                var dbData = ' . json_encode($db_data, JSON_UNESCAPED_UNICODE) . ';
                for (var key in dbData) {
                    ChatbotData[key] = dbData[key];
                }
            }
        </script>';
    }
}
add_action('wp_footer', 'websiteku_output_chatbot_db_data', 5);
