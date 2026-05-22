<?php
/**
 * Theme Functions
 * 
 * @package Websiteku
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Materi helpers (kelas, TP, video)
require_once get_template_directory() . '/inc/materi-helpers.php';

// Include Custom Post Types
require_once get_template_directory() . '/inc/custom-post-types.php';

// Include Theme Settings
require_once get_template_directory() . '/inc/theme-settings.php';

// Include Chatbot Admin
require_once get_template_directory() . '/inc/chatbot-admin.php';

// Include Quiz Admin
require_once get_template_directory() . '/inc/quiz-admin.php';

/**
 * Theme Setup
 */
function websiteku_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 100,
        'flex-height' => true,
        'flex-width' => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'websiteku'),
        'footer' => __('Footer Menu', 'websiteku'),
    ));
}
add_action('after_setup_theme', 'websiteku_setup');

/**
 * Enqueue Scripts and Styles
 */
function websiteku_scripts()
{
    // Font Awesome Icons
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Google Fonts
    wp_enqueue_style(
        'websiteku-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'websiteku-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Chatbot styles
    wp_enqueue_style(
        'websiteku-chatbot',
        get_template_directory_uri() . '/assets/css/chatbot.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Main JavaScript
    wp_enqueue_script(
        'websiteku-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Chatbot data
    wp_enqueue_script(
        'websiteku-chatbot-data',
        get_template_directory_uri() . '/assets/js/chatbot-data.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_script(
        'websiteku-materi-kelas',
        get_template_directory_uri() . '/assets/js/materi-kelas.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    wp_localize_script('websiteku-materi-kelas', 'websitekuMateriContext', array(
        'items' => websiteku_get_materi_chatbot_context(),
        'tp_referensi' => websiteku_get_tp_referensi_kelas(),
    ));

    // Chatbot script
    wp_enqueue_script(
        'websiteku-chatbot',
        get_template_directory_uri() . '/assets/js/chatbot.js',
        array('websiteku-chatbot-data', 'websiteku-materi-kelas'),
        wp_get_theme()->get('Version'),
        true
    );

    // Pass n8n config to frontend
    $n8n_timeout_sec = absint(websiteku_get_option('n8n_timeout', 30));
    if ($n8n_timeout_sec < 5) {
        $n8n_timeout_sec = 30;
    }

    $n8n_config = array(
        'enabled' => websiteku_get_option('n8n_enabled', '0') === '1',
        'webhook_url' => websiteku_get_option('n8n_webhook_url', ''),
        'timeout' => $n8n_timeout_sec * 1000,
        'api_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('websiteku_chatbot_n8n'),
        'school_name' => websiteku_get_option('school_name', 'SDIT Global Insan Madani'),
        'leaderboard_nonce' => wp_create_nonce('websiteku_leaderboard_nonce'),
        'kelas_options' => websiteku_get_kelas_options(),
    );
    wp_localize_script('websiteku-chatbot', 'websitekuN8nConfig', $n8n_config);

    wp_enqueue_style(
        'websiteku-materi',
        get_template_directory_uri() . '/assets/css/materi.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_localize_script('websiteku-quiz', 'websiteku_vars', array(
        'rest_url' => esc_url_raw(rest_url()),
        'home_url' => esc_url_raw(home_url('/')),
    ));

    // Quiz styles
    wp_enqueue_style(
        'websiteku-quiz',
        get_template_directory_uri() . '/assets/css/quiz.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Quiz data
    wp_enqueue_script(
        'websiteku-quiz-data',
        get_template_directory_uri() . '/assets/js/quiz-data.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Quiz script
    wp_enqueue_script(
        'websiteku-quiz',
        get_template_directory_uri() . '/assets/js/quiz.js',
        array('websiteku-quiz-data'),
        wp_get_theme()->get('Version'),
        true
    );

    // Certificate script
    wp_enqueue_script(
        'websiteku-certificate',
        get_template_directory_uri() . '/assets/js/certificate.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Loading styles
    wp_enqueue_style(
        'websiteku-loading',
        get_template_directory_uri() . '/assets/css/loading.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Loading & Progress script
    wp_enqueue_script(
        'websiteku-loading',
        get_template_directory_uri() . '/assets/js/loading.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Quick Features (Dark Mode, Back to Top, Print CSS)
    wp_enqueue_style(
        'websiteku-quick-features',
        get_template_directory_uri() . '/assets/css/quick-features.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'websiteku-quick-features',
        get_template_directory_uri() . '/assets/js/quick-features.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // Search
    wp_enqueue_style(
        'websiteku-search',
        get_template_directory_uri() . '/assets/css/search.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'websiteku-search',
        get_template_directory_uri() . '/assets/js/search.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'websiteku_scripts');

/**
 * Register Widget Areas
 */
function websiteku_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'websiteku'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'websiteku'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget', 'websiteku'),
        'id' => 'footer-1',
        'description' => __('Add footer widgets here.', 'websiteku'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'websiteku_widgets_init');

/**
 * Custom excerpt length
 */
function websiteku_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'websiteku_excerpt_length');

/**
 * Custom excerpt more
 */
function websiteku_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'websiteku_excerpt_more');

/**
 * Get theme asset URL
 */
function websiteku_asset($path)
{
    return get_template_directory_uri() . '/assets/' . $path;
}

/**
 * Get theme image URL
 */
function websiteku_image($filename)
{
    return get_template_directory_uri() . '/assets/images/' . $filename;
}

/**
 * n8n Chatbot Proxy Endpoint
 * 
 * Proxy request ke n8n webhook untuk keamanan (hindari CORS dan expose webhook URL)
 */
function websiteku_chatbot_n8n_proxy()
{
    // Verify nonce
    check_ajax_referer('websiteku_chatbot_n8n', 'nonce');

    $n8n_webhook = websiteku_get_option('n8n_webhook_url', '');
    $n8n_enabled = websiteku_get_option('n8n_enabled', '0') === '1';

    // Check if n8n is enabled and webhook URL exists
    if (!$n8n_enabled || empty($n8n_webhook)) {
        wp_send_json_error(array(
            'message' => 'n8n tidak diaktifkan atau webhook URL tidak ditemukan',
            'fallback' => true
        ));
        return;
    }

    $user_kelas = isset($_POST['kelas']) ? absint($_POST['kelas']) : 0;

    // Get user message
    $user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    if (empty($user_message)) {
        wp_send_json_error(array(
            'message' => 'Pesan tidak boleh kosong',
            'fallback' => true
        ));
        return;
    }

    // Generate unique session ID for chat memory
    $session_id = isset($_COOKIE['websiteku_chat_session']) ? sanitize_text_field($_COOKIE['websiteku_chat_session']) : wp_generate_uuid4();
    if (!isset($_COOKIE['websiteku_chat_session'])) {
        setcookie('websiteku_chat_session', $session_id, time() + (86400 * 30), '/'); // 30 days
    }

    // Prepare request to n8n chat trigger
    // Format sesuai dengan n8n Chat Trigger node
    $materi_context = websiteku_get_materi_chatbot_context($user_kelas > 0 ? (string) $user_kelas : null);
    $context_summary = array();
    foreach (array_slice($materi_context, 0, 8) as $m) {
        $context_summary[] = $m['title'] . ' (Kelas ' . $m['kelas'] . '): ' . wp_trim_words($m['answer'], 40, '...');
    }

    $body = array(
        'action' => 'sendMessage',
        'sessionId' => $session_id,
        'chatInput' => $user_message,
        'kelas' => $user_kelas,
        'materiContext' => $context_summary,
        'schoolName' => websiteku_get_option('school_name', 'SDIT Global Insan Madani'),
    );

    $proxy_timeout = absint(websiteku_get_option('n8n_timeout', 30));
    if ($proxy_timeout < 5) {
        $proxy_timeout = 30;
    }

    $response = wp_remote_post($n8n_webhook, array(
        'timeout' => $proxy_timeout,
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($body),
        'sslverify' => true,
    ));

    // Handle response
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log('n8n Error: ' . $error_message);
        wp_send_json_error(array(
            'message' => 'Gagal terhubung ke n8n: ' . $error_message,
            'error_code' => $response->get_error_code(),
            'fallback' => true
        ));
        return;
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($status_code !== 200) {
        error_log('n8n HTTP Error: ' . $status_code . ' - ' . $response_body);
        wp_send_json_error(array(
            'message' => 'n8n mengembalikan error (HTTP ' . $status_code . ')',
            'status_code' => $status_code,
            'response_body' => substr($response_body, 0, 200), // First 200 chars for debugging
            'fallback' => true
        ));
        return;
    }

    // Parse n8n response
    $data = json_decode($response_body, true);

    // n8n Chat Trigger dan Agent bisa return berbagai format
    $answer = null;

    // Format dari n8n Chat Trigger / AI Agent
    if (isset($data['output'])) {
        $answer = $data['output'];
    } elseif (isset($data['answer'])) {
        $answer = $data['answer'];
    } elseif (isset($data['response'])) {
        $answer = $data['response'];
    } elseif (isset($data['text'])) {
        $answer = $data['text'];
    } elseif (isset($data['message'])) {
        $answer = $data['message'];
    } elseif (is_string($response_body) && !empty($response_body)) {
        $answer = $response_body;
    } elseif (is_array($data) && isset($data[0])) {
        // Array response
        $answer = is_array($data[0]) ? (isset($data[0]['output']) ? $data[0]['output'] : json_encode($data[0])) : $data[0];
    }

    if ($answer) {
        wp_send_json_success(array(
            'answer' => $answer
        ));
    } else {
        error_log('n8n Unknown Response Format: ' . $response_body);
        wp_send_json_error(array(
            'message' => 'Format response tidak dikenali',
            'raw_response' => substr($response_body, 0, 500),
            'fallback' => true
        ));
    }
}
add_action('wp_ajax_websiteku_chatbot_n8n', 'websiteku_chatbot_n8n_proxy');
add_action('wp_ajax_nopriv_websiteku_chatbot_n8n', 'websiteku_chatbot_n8n_proxy'); // Allow non-logged in users

/**
 * Leaderboard AJAX Handlers
 */
function websiteku_save_quiz_score() {
    check_ajax_referer('websiteku_leaderboard_nonce', 'nonce');
    
    $student_name = isset($_POST['student_name']) ? sanitize_text_field($_POST['student_name']) : 'Anonim';
    $score = isset($_POST['score']) ? intval($_POST['score']) : 0;
    $quiz_id = isset($_POST['quiz_id']) ? sanitize_text_field($_POST['quiz_id']) : '';
    
    $leaderboard = get_option('websiteku_leaderboard', array());
    
    // Add new score
    $leaderboard[] = array(
        'name' => $student_name,
        'score' => $score,
        'quiz_id' => $quiz_id,
        'date' => current_time('mysql')
    );
    
    // Sort descending by score
    usort($leaderboard, function($a, $b) {
        return $b['score'] - $a['score'];
    });
    
    // Keep top 100 to prevent db bloat
    if (count($leaderboard) > 100) {
        $leaderboard = array_slice($leaderboard, 0, 100);
    }
    
    update_option('websiteku_leaderboard', $leaderboard);
    wp_send_json_success('Score saved successfully');
}
add_action('wp_ajax_websiteku_save_quiz_score', 'websiteku_save_quiz_score');
add_action('wp_ajax_nopriv_websiteku_save_quiz_score', 'websiteku_save_quiz_score');

function websiteku_get_leaderboard() {
    $leaderboard = get_option('websiteku_leaderboard', array());
    // Get top 10
    $top_10 = array_slice($leaderboard, 0, 10);
    wp_send_json_success($top_10);
}
add_action('wp_ajax_websiteku_get_leaderboard', 'websiteku_get_leaderboard');
add_action('wp_ajax_nopriv_websiteku_get_leaderboard', 'websiteku_get_leaderboard');
