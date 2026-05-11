<?php
/**
 * Custom Post Type: Quiz
 * 
 * Memungkinkan pengelolaan quiz dari wp-admin
 * 
 * @package Websiteku
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Type: Quiz
 */
function websiteku_register_quiz_cpt()
{
    $labels = array(
        'name' => 'Quiz TIK',
        'singular_name' => 'Quiz',
        'menu_name' => 'Quiz TIK',
        'name_admin_bar' => 'Quiz',
        'add_new' => 'Tambah Quiz',
        'add_new_item' => 'Tambah Quiz Baru',
        'new_item' => 'Quiz Baru',
        'edit_item' => 'Edit Quiz',
        'view_item' => 'Lihat Quiz',
        'all_items' => 'Semua Quiz',
        'search_items' => 'Cari Quiz',
        'not_found' => 'Quiz tidak ditemukan',
        'not_found_in_trash' => 'Tidak ada quiz di Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'quiz'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'supports' => array('title'),
        'show_in_rest' => false,
    );

    register_post_type('quiz', $args);
}
add_action('init', 'websiteku_register_quiz_cpt');

/**
 * Add Meta Boxes for Quiz
 */
function websiteku_quiz_meta_boxes()
{
    add_meta_box(
        'quiz_details',
        'Detail Quiz',
        'websiteku_quiz_details_callback',
        'quiz',
        'normal',
        'high'
    );

    add_meta_box(
        'quiz_questions',
        'Pertanyaan Quiz',
        'websiteku_quiz_questions_callback',
        'quiz',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'websiteku_quiz_meta_boxes');

/**
 * Quiz Details Meta Box
 */
function websiteku_quiz_details_callback($post)
{
    wp_nonce_field('websiteku_quiz_nonce', 'quiz_nonce');

    $quiz_id = get_post_meta($post->ID, '_quiz_id', true);
    $time_limit = get_post_meta($post->ID, '_quiz_time_limit', true) ?: 30;
    $pass_score = get_post_meta($post->ID, '_quiz_pass_score', true) ?: 70;
    ?>
    <style>
        .quiz-meta-row {
            margin-bottom: 15px;
        }

        .quiz-meta-row label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .quiz-meta-row input[type="text"],
        .quiz-meta-row input[type="number"],
        .quiz-meta-row select {
            width: 100%;
            max-width: 400px;
            padding: 8px;
        }

        .quiz-meta-row .description {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    <div class="quiz-meta-row">
        <label for="quiz_id">ID Quiz (untuk link ke Materi)</label>
        <input type="text" id="quiz_id" name="quiz_id" value="<?php echo esc_attr($quiz_id); ?>"
            placeholder="contoh: pengenalan-komputer">
        <p class="description">ID unik quiz, gunakan huruf kecil dan strip. Contoh: pengenalan-komputer, hardware, software
        </p>
    </div>

    <div class="quiz-meta-row">
        <label for="quiz_time_limit">Batas Waktu (detik)</label>
        <input type="number" id="quiz_time_limit" name="quiz_time_limit" value="<?php echo esc_attr($time_limit); ?>"
            min="10" max="300">
        <p class="description">Waktu untuk menjawab setiap pertanyaan dalam detik.</p>
    </div>

    <div class="quiz-meta-row">
        <label for="quiz_pass_score">Nilai Kelulusan (%)</label>
        <input type="number" id="quiz_pass_score" name="quiz_pass_score" value="<?php echo esc_attr($pass_score); ?>"
            min="0" max="100">
        <p class="description">Persentase minimum untuk lulus quiz.</p>
    </div>
    <?php
}

/**
 * Quiz Questions Meta Box
 */
function websiteku_quiz_questions_callback($post)
{
    $questions = get_post_meta($post->ID, '_quiz_questions', true);
    if (!is_array($questions)) {
        $questions = array();
    }
    ?>
    <style>
        .questions-container {
            margin-top: 10px;
        }

        .question-item {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
        }

        .question-item.collapsed .question-content {
            display: none;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .question-header h4 {
            margin: 0;
            color: #2E7D32;
        }

        .question-actions button {
            margin-left: 5px;
        }

        .question-content label {
            display: block;
            font-weight: 500;
            margin: 10px 0 5px;
        }

        .question-content input[type="text"],
        .question-content textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }

        .option-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .option-row input[type="text"] {
            flex: 1;
        }

        .option-row input[type="radio"] {
            cursor: pointer;
        }

        #add-question-btn {
            margin-top: 15px;
            background: #2E7D32;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #add-question-btn:hover {
            background: #1b5e20;
        }

        .remove-question {
            color: #d00;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>

    <div class="questions-container" id="questions-container">
        <?php
        if (!empty($questions)):
            foreach ($questions as $index => $q):
                ?>
                <div class="question-item" data-index="<?php echo $index; ?>">
                    <div class="question-header" onclick="toggleQuestion(this)">
                        <h4>Pertanyaan
                            <?php echo $index + 1; ?>:
                            <?php echo esc_html(substr($q['question'], 0, 50)); ?>...
                        </h4>
                        <div class="question-actions">
                            <button type="button" class="button remove-question"
                                onclick="removeQuestion(this, event)">Hapus</button>
                        </div>
                    </div>
                    <div class="question-content">
                        <label>Pertanyaan</label>
                        <textarea name="quiz_questions[<?php echo $index; ?>][question]"
                            rows="2"><?php echo esc_textarea($q['question']); ?></textarea>

                        <label>Pilihan Jawaban (pilih yang benar)</label>
                        <div class="options-grid">
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <div class="option-row">
                                    <input type="radio" name="quiz_questions[<?php echo $index; ?>][correct]" value="<?php echo $i; ?>"
                                        <?php checked($q['correct'], $i); ?>>
                                    <input type="text" name="quiz_questions[<?php echo $index; ?>][options][<?php echo $i; ?>]"
                                        value="<?php echo esc_attr($q['options'][$i] ?? ''); ?>"
                                        placeholder="Opsi <?php echo chr(65 + $i); ?>">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        endif;
        ?>
    </div>

    <button type="button" id="add-question-btn" onclick="addQuestion()">+ Tambah Pertanyaan</button>

    <script>
        let questionIndex = <?php echo count($questions); ?>;

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const html = `
                <div class="question-item" data-index="${questionIndex}">
                    <div class="question-header" onclick="toggleQuestion(this)">
                        <h4>Pertanyaan ${questionIndex + 1}: (Baru)</h4>
                        <div class="question-actions">
                            <button type="button" class="button remove-question" onclick="removeQuestion(this, event)">Hapus</button>
                        </div>
                    </div>
                    <div class="question-content">
                        <label>Pertanyaan</label>
                        <textarea name="quiz_questions[${questionIndex}][question]" rows="2"></textarea>

                        <label>Pilihan Jawaban (pilih yang benar)</label>
                        <div class="options-grid">
                            <div class="option-row">
                                <input type="radio" name="quiz_questions[${questionIndex}][correct]" value="0" checked>
                                <input type="text" name="quiz_questions[${questionIndex}][options][0]" placeholder="Opsi A">
                            </div>
                            <div class="option-row">
                                <input type="radio" name="quiz_questions[${questionIndex}][correct]" value="1">
                                <input type="text" name="quiz_questions[${questionIndex}][options][1]" placeholder="Opsi B">
                            </div>
                            <div class="option-row">
                                <input type="radio" name="quiz_questions[${questionIndex}][correct]" value="2">
                                <input type="text" name="quiz_questions[${questionIndex}][options][2]" placeholder="Opsi C">
                            </div>
                            <div class="option-row">
                                <input type="radio" name="quiz_questions[${questionIndex}][correct]" value="3">
                                <input type="text" name="quiz_questions[${questionIndex}][options][3]" placeholder="Opsi D">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            questionIndex++;
        }

        function removeQuestion(btn, e) {
            e.stopPropagation();
            if (confirm('Yakin hapus pertanyaan ini?')) {
                btn.closest('.question-item').remove();
                renumberQuestions();
            }
        }

        function toggleQuestion(header) {
            header.closest('.question-item').classList.toggle('collapsed');
        }

        function renumberQuestions() {
            document.querySelectorAll('.question-item').forEach((item, idx) => {
                item.querySelector('h4').textContent = `Pertanyaan ${idx + 1}: ${item.querySelector('textarea').value.substring(0, 50) || '(Baru)'}...`;
            });
        }
    </script>
    <?php
}

/**
 * Save Quiz Meta Data
 */
function websiteku_save_quiz_meta($post_id)
{
    // Security checks
    if (!isset($_POST['quiz_nonce']) || !wp_verify_nonce($_POST['quiz_nonce'], 'websiteku_quiz_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save quiz details
    if (isset($_POST['quiz_id'])) {
        update_post_meta($post_id, '_quiz_id', sanitize_text_field($_POST['quiz_id']));
    }
    if (isset($_POST['quiz_time_limit'])) {
        update_post_meta($post_id, '_quiz_time_limit', intval($_POST['quiz_time_limit']));
    }
    if (isset($_POST['quiz_pass_score'])) {
        update_post_meta($post_id, '_quiz_pass_score', intval($_POST['quiz_pass_score']));
    }

    // Save questions
    if (isset($_POST['quiz_questions']) && is_array($_POST['quiz_questions'])) {
        $questions = array();
        foreach ($_POST['quiz_questions'] as $q) {
            if (!empty($q['question']) && !empty($q['options'])) {
                $questions[] = array(
                    'question' => sanitize_text_field($q['question']),
                    'options' => array_map('sanitize_text_field', $q['options']),
                    'correct' => intval($q['correct'])
                );
            }
        }
        update_post_meta($post_id, '_quiz_questions', $questions);
    }
}
add_action('save_post_quiz', 'websiteku_save_quiz_meta');

/**
 * Quiz columns
 */
function websiteku_quiz_columns($columns)
{
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['quiz_id'] = 'Quiz ID';
    $new_columns['questions_count'] = 'Jumlah Soal';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_quiz_posts_columns', 'websiteku_quiz_columns');

function websiteku_quiz_column_content($column, $post_id)
{
    switch ($column) {
        case 'quiz_id':
            $quiz_id = get_post_meta($post_id, '_quiz_id', true);
            echo $quiz_id ? '<code>' . esc_html($quiz_id) . '</code>' : '-';
            break;
        case 'questions_count':
            $questions = get_post_meta($post_id, '_quiz_questions', true);
            $count = is_array($questions) ? count($questions) : 0;
            echo $count . ' soal';
            break;
    }
}
add_action('manage_quiz_posts_custom_column', 'websiteku_quiz_column_content', 10, 2);

/**
 * Get quiz by ID
 */
function websiteku_get_quiz_by_id($quiz_id)
{
    $args = array(
        'post_type' => 'quiz',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_quiz_id',
                'value' => $quiz_id,
                'compare' => '='
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        wp_reset_postdata();

        return array(
            'id' => $quiz_id,
            'title' => get_the_title($post_id),
            'timeLimit' => get_post_meta($post_id, '_quiz_time_limit', true) ?: 30,
            'passScore' => get_post_meta($post_id, '_quiz_pass_score', true) ?: 70,
            'questions' => get_post_meta($post_id, '_quiz_questions', true) ?: array()
        );
    }

    return null;
}

/**
 * REST API endpoint for quiz
 */
function websiteku_register_quiz_api()
{
    register_rest_route('websiteku/v1', '/quiz/(?P<id>[^/]+)', array(
        'methods' => 'GET',
        'callback' => 'websiteku_get_quiz_api',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'websiteku_register_quiz_api');

function websiteku_get_quiz_api($request)
{
    $quiz_id = urldecode($request['id']);
    $quiz = websiteku_get_quiz_by_id($quiz_id);

    if (!$quiz) {
        return new WP_Error('quiz_not_found', 'Quiz tidak ditemukan', array('status' => 404));
    }

    return rest_ensure_response($quiz);
}
