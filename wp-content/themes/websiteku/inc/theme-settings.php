<?php
/**
 * Theme Settings Page
 * 
 * Halaman pengaturan tema di wp-admin
 * 
 * @package Websiteku
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Settings Page to Admin Menu
 */
function websiteku_add_settings_page()
{
    add_menu_page(
        'Pengaturan Websiteku',
        'Pengaturan Tema',
        'manage_options',
        'websiteku-settings',
        'websiteku_settings_page_html',
        'dashicons-admin-customizer',
        60
    );
}
add_action('admin_menu', 'websiteku_add_settings_page');

/**
 * Register Settings
 */
function websiteku_register_settings()
{
    // Register setting group
    register_setting('websiteku_settings', 'websiteku_options', array(
        'sanitize_callback' => 'websiteku_sanitize_options'
    ));

    // Info Sekolah Section
    add_settings_section(
        'websiteku_info_section',
        '🏫 Informasi Sekolah',
        function () {
            echo '<p>Pengaturan informasi dasar sekolah</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('school_name', 'Nama Sekolah', 'websiteku_field_text', 'websiteku-settings', 'websiteku_info_section', ['field' => 'school_name', 'default' => 'SDIT Global Insan Madani']);
    add_settings_field('school_tagline', 'Tagline', 'websiteku_field_text', 'websiteku-settings', 'websiteku_info_section', ['field' => 'school_tagline', 'default' => 'Sekolah Dasar Islam Terpadu']);
    add_settings_field('school_address', 'Alamat', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_info_section', ['field' => 'school_address', 'default' => 'Jl. Contoh Alamat No. 123, Kota']);
    add_settings_field('school_phone', 'Telepon', 'websiteku_field_text', 'websiteku-settings', 'websiteku_info_section', ['field' => 'school_phone', 'default' => '(021) xxxx-xxxx']);
    add_settings_field('school_email', 'Email', 'websiteku_field_text', 'websiteku-settings', 'websiteku_info_section', ['field' => 'school_email', 'default' => 'info@sditglobalinsanmadani.sch.id']);

    // Visi Misi Section
    add_settings_section(
        'websiteku_visimisi_section',
        '🎯 Visi & Misi',
        function () {
            echo '<p>Pengaturan Visi dan Misi sekolah</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('sekolah_visi', 'Visi', 'websiteku_field_wysiwyg', 'websiteku-settings', 'websiteku_visimisi_section', ['field' => 'sekolah_visi', 'default' => 'Menjadi lembaga pendidikan Islam terpadu yang unggul dalam IMTAQ dan IPTEK, menghasilkan generasi yang berakhlak mulia, cerdas, mandiri, dan berwawasan global.']);
    add_settings_field('sekolah_misi', 'Misi', 'websiteku_field_wysiwyg', 'websiteku-settings', 'websiteku_visimisi_section', ['field' => 'sekolah_misi', 'default' => "<ul><li>Menyelenggarakan pendidikan yang mengintegrasikan ilmu pengetahuan dan nilai-nilai Islam</li><li>Mengembangkan potensi siswa secara optimal dalam bidang akademik dan non-akademik</li><li>Membentuk karakter siswa yang berakhlak mulia dan bertanggung jawab</li><li>Membekali siswa dengan keterampilan teknologi informasi yang bermanfaat</li><li>Menciptakan lingkungan belajar yang kondusif, aman, dan nyaman</li></ul>"]);

    // Hero Section
    add_settings_section(
        'websiteku_hero_section',
        '🚀 Hero Section',
        function () {
            echo '<p>Pengaturan tampilan hero di halaman utama</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('hero_badge', 'Badge Text', 'websiteku_field_text', 'websiteku-settings', 'websiteku_hero_section', ['field' => 'hero_badge', 'default' => '🖥️ Pembelajaran Interaktif']);
    add_settings_field('hero_title', 'Judul Hero', 'websiteku_field_text', 'websiteku-settings', 'websiteku_hero_section', ['field' => 'hero_title', 'default' => 'Belajar TIK Jadi Menyenangkan!']);
    add_settings_field('hero_subtitle', 'Subtitle Hero', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_hero_section', ['field' => 'hero_subtitle', 'default' => 'Selamat datang di portal pembelajaran Teknologi Informasi & Komunikasi SDIT Global Insan Madani. Mari belajar bersama!']);

    // Social Media Section
    add_settings_section(
        'websiteku_social_section',
        '📱 Sosial Media',
        function () {
            echo '<p>Link akun sosial media sekolah</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('social_instagram', 'Instagram URL', 'websiteku_field_url', 'websiteku-settings', 'websiteku_social_section', ['field' => 'social_instagram']);
    add_settings_field('social_facebook', 'Facebook URL', 'websiteku_field_url', 'websiteku-settings', 'websiteku_social_section', ['field' => 'social_facebook']);
    add_settings_field('social_youtube', 'YouTube URL', 'websiteku_field_url', 'websiteku-settings', 'websiteku_social_section', ['field' => 'social_youtube']);
    add_settings_field('social_whatsapp', 'WhatsApp Number', 'websiteku_field_text', 'websiteku-settings', 'websiteku_social_section', ['field' => 'social_whatsapp', 'placeholder' => '628123456789']);

    // Logo Section
    add_settings_section(
        'websiteku_logo_section',
        '<i class="dashicons dashicons-format-image"></i> Logo',
        function () {
            echo '<p>Upload logo sekolah</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('site_logo', 'Logo Sekolah', 'websiteku_field_image', 'websiteku-settings', 'websiteku_logo_section', ['field' => 'site_logo']);

    // Info Mapel Section
    add_settings_section(
        'websiteku_mapel_section',
        '<i class="dashicons dashicons-welcome-learn-more"></i> Info Mapel (4 Cards)',
        function () {
            echo '<p>Pengaturan 4 kartu info di section "Tentang Mapel TIK"</p>';
        },
        'websiteku-settings'
    );

    // Card 1
    add_settings_field('mapel_card1_icon', 'Card 1 - Icon (FA)', 'websiteku_field_icon_select', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card1_icon', 'default' => 'fa-bullseye']);
    add_settings_field('mapel_card1_title', 'Card 1 - Judul', 'websiteku_field_text', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card1_title', 'default' => 'Tujuan Pembelajaran']);
    add_settings_field('mapel_card1_desc', 'Card 1 - Deskripsi', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card1_desc', 'default' => 'Membekali siswa dengan pengetahuan dan keterampilan dasar dalam menggunakan teknologi informasi secara bijak dan bertanggung jawab.']);

    // Card 2
    add_settings_field('mapel_card2_icon', 'Card 2 - Icon (FA)', 'websiteku_field_icon_select', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card2_icon', 'default' => 'fa-lightbulb']);
    add_settings_field('mapel_card2_title', 'Card 2 - Judul', 'websiteku_field_text', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card2_title', 'default' => 'Kompetensi Dasar']);
    add_settings_field('mapel_card2_desc', 'Card 2 - Deskripsi', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card2_desc', 'default' => 'Mengenal perangkat keras & lunak komputer, memahami cara kerja internet, dan menerapkan keamanan digital.']);

    // Card 3
    add_settings_field('mapel_card3_icon', 'Card 3 - Icon (FA)', 'websiteku_field_icon_select', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card3_icon', 'default' => 'fa-book-open']);
    add_settings_field('mapel_card3_title', 'Card 3 - Judul', 'websiteku_field_text', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card3_title', 'default' => 'Metode Pembelajaran']);
    add_settings_field('mapel_card3_desc', 'Card 3 - Deskripsi', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card3_desc', 'default' => 'Pembelajaran interaktif dengan praktik langsung, diskusi kelompok, dan bantuan chatbot untuk tanya jawab materi.']);

    // Card 4
    add_settings_field('mapel_card4_icon', 'Card 4 - Icon (FA)', 'websiteku_field_icon_select', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card4_icon', 'default' => 'fa-trophy']);
    add_settings_field('mapel_card4_title', 'Card 4 - Judul', 'websiteku_field_text', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card4_title', 'default' => 'Target Capaian']);
    add_settings_field('mapel_card4_desc', 'Card 4 - Deskripsi', 'websiteku_field_textarea', 'websiteku-settings', 'websiteku_mapel_section', ['field' => 'mapel_card4_desc', 'default' => 'Siswa mampu mengoperasikan komputer, menggunakan aplikasi produktivitas, dan memahami etika digital.']);

    // Footer Section
    add_settings_section(
        'websiteku_footer_section',
        '📄 Footer',
        function () {
            echo '<p>Pengaturan footer website</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('footer_copyright', 'Teks Copyright', 'websiteku_field_text', 'websiteku-settings', 'websiteku_footer_section', ['field' => 'footer_copyright', 'default' => '© 2024 SDIT Global Insan Madani. All rights reserved.']);
    add_settings_field('footer_maps_embed', 'Google Maps Embed', 'websiteku_field_maps', 'websiteku-settings', 'websiteku_footer_section', ['field' => 'footer_maps_embed']);

    // Chatbot n8n Section
    add_settings_section(
        'websiteku_chatbot_section',
        '🤖 Chatbot n8n Integration',
        function () {
            echo '<p>Integrasikan chatbot dengan n8n untuk AI-powered responses. Jika tidak diisi, chatbot akan menggunakan sistem rule-based default.</p>';
        },
        'websiteku-settings'
    );

    add_settings_field('n8n_webhook_url', 'n8n Webhook URL', 'websiteku_field_n8n_webhook', 'websiteku-settings', 'websiteku_chatbot_section', ['field' => 'n8n_webhook_url']);
    add_settings_field('n8n_enabled', 'Aktifkan n8n', 'websiteku_field_checkbox', 'websiteku-settings', 'websiteku_chatbot_section', ['field' => 'n8n_enabled', 'label' => 'Gunakan n8n untuk chatbot (jika kosong, gunakan rule-based)']);
    add_settings_field('n8n_timeout', 'Timeout (detik)', 'websiteku_field_number', 'websiteku-settings', 'websiteku_chatbot_section', ['field' => 'n8n_timeout', 'default' => '5', 'min' => 1, 'max' => 30]);
}
add_action('admin_init', 'websiteku_register_settings');

/**
 * Field Callbacks
 */
function websiteku_field_text($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : ($args['default'] ?? '');
    $placeholder = $args['placeholder'] ?? '';
    echo '<input type="text" name="websiteku_options[' . esc_attr($args['field']) . ']" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr($placeholder) . '">';
}

function websiteku_field_textarea($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : ($args['default'] ?? '');
    echo '<textarea name="websiteku_options[' . esc_attr($args['field']) . ']" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function websiteku_field_wysiwyg($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : ($args['default'] ?? '');
    wp_editor($value, $args['field'], array(
        'textarea_name' => 'websiteku_options[' . esc_attr($args['field']) . ']',
        'textarea_rows' => 5,
        'media_buttons' => false,
        'tinymce' => array(
            'toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink,undo,redo'
        ),
        'quicktags' => true
    ));
}

function websiteku_field_url($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    echo '<input type="url" name="websiteku_options[' . esc_attr($args['field']) . ']" value="' . esc_url($value) . '" class="regular-text" placeholder="https://">';
}

function websiteku_field_maps($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    ?>
    <textarea name="websiteku_options[<?php echo esc_attr($args['field']); ?>]" rows="4" class="large-text"
        placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'><?php echo esc_textarea($value); ?></textarea>
    <p class="description">
        Cara mendapatkan embed code:
    <ol style="margin: 5px 0 0 20px;">
        <li>Buka <a href="https://maps.google.com" target="_blank">Google Maps</a></li>
        <li>Cari lokasi sekolah</li>
        <li>Klik tombol "Share" → "Embed a map"</li>
        <li>Copy iframe code dan paste di sini</li>
    </ol>
    </p>
    <?php
}

function websiteku_field_n8n($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    ?>
    <input type="url" name="websiteku_options[<?php echo esc_attr($args['field']); ?>]"
        value="<?php echo esc_url($value); ?>" class="large-text" placeholder="https://your-n8n.com/webhook/xxx/chat">
    <p class="description">
        URL webhook dari n8n. Dapatkan dari workflow n8n > node "When chat message received".
        <br>Format: <code>https://n8n-xxx.com/webhook/xxx/chat</code>
    </p>
    <?php
}

function websiteku_field_image($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    ?>
    <div class="image-upload-field">
        <input type="hidden" name="websiteku_options[<?php echo esc_attr($args['field']); ?>]"
            id="<?php echo esc_attr($args['field']); ?>" value="<?php echo esc_attr($value); ?>">
        <div class="image-preview" id="<?php echo esc_attr($args['field']); ?>_preview" style="margin-bottom: 10px;">
            <?php if ($value): ?>
                <img src="<?php echo esc_url($value); ?>" style="max-width: 200px; height: auto; border-radius: 8px;">
            <?php endif; ?>
        </div>
        <button type="button" class="button upload-image-btn" data-field="<?php echo esc_attr($args['field']); ?>">
            <span class="dashicons dashicons-upload" style="vertical-align: middle;"></span> Upload Logo
        </button>
        <?php if ($value): ?>
            <button type="button" class="button remove-image-btn" data-field="<?php echo esc_attr($args['field']); ?>"
                style="color: #a00;">
                <span class="dashicons dashicons-trash" style="vertical-align: middle;"></span> Hapus
            </button>
        <?php endif; ?>
    </div>
    <?php
}

function websiteku_field_icon_select($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : ($args['default'] ?? 'fa-star');

    $icons = [
        'fa-bullseye' => 'Target',
        'fa-lightbulb' => 'Lightbulb',
        'fa-book-open' => 'Book Open',
        'fa-trophy' => 'Trophy',
        'fa-graduation-cap' => 'Graduation',
        'fa-chalkboard-teacher' => 'Teacher',
        'fa-laptop' => 'Laptop',
        'fa-desktop' => 'Desktop',
        'fa-code' => 'Code',
        'fa-globe' => 'Globe',
        'fa-shield-alt' => 'Shield',
        'fa-users' => 'Users',
        'fa-star' => 'Star',
        'fa-heart' => 'Heart',
        'fa-rocket' => 'Rocket',
        'fa-cog' => 'Cog',
    ];

    echo '<select name="websiteku_options[' . esc_attr($args['field']) . ']">';
    foreach ($icons as $icon_class => $icon_name) {
        $selected = ($value === $icon_class) ? 'selected' : '';
        echo '<option value="' . esc_attr($icon_class) . '" ' . $selected . '>' . esc_html($icon_name) . '</option>';
    }
    echo '</select>';
}

function websiteku_field_n8n_webhook($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    ?>
    <input type="url" name="websiteku_options[<?php echo esc_attr($args['field']); ?>]"
        value="<?php echo esc_url($value); ?>" class="regular-text"
        placeholder="https://your-n8n-instance.com/webhook/chatbot">
    <p class="description">
        Masukkan URL webhook n8n untuk chatbot. Format: <code>https://your-n8n-instance.com/webhook/chatbot</code><br>
        <strong>Cara mendapatkan:</strong>
    <ol style="margin: 5px 0 0 20px;">
        <li>Buat workflow di n8n dengan Webhook trigger</li>
        <li>Copy URL webhook yang dihasilkan</li>
        <li>Paste URL di sini</li>
    </ol>
    </p>
    <?php
}

function websiteku_field_checkbox($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '0';
    $label = $args['label'] ?? '';
    ?>
    <label>
        <input type="checkbox" name="websiteku_options[<?php echo esc_attr($args['field']); ?>]" value="1" <?php checked($value, '1'); ?>>
        <?php echo esc_html($label); ?>
    </label>
    <?php
}

function websiteku_field_number($args)
{
    $options = get_option('websiteku_options', []);
    $value = isset($options[$args['field']]) ? $options[$args['field']] : ($args['default'] ?? '5');
    $min = $args['min'] ?? '';
    $max = $args['max'] ?? '';
    ?>
    <input type="number" name="websiteku_options[<?php echo esc_attr($args['field']); ?>]"
        value="<?php echo esc_attr($value); ?>" class="small-text" min="<?php echo esc_attr($min); ?>"
        max="<?php echo esc_attr($max); ?>" step="1">
    <p class="description">Waktu maksimal menunggu response dari n8n (dalam detik). Jika timeout, akan fallback ke
        rule-based.</p>
    <?php
}

/**
 * Sanitize Options
 */
function websiteku_sanitize_options($input)
{
    $sanitized = [];
    foreach ($input as $key => $value) {
        if (strpos($key, 'url') !== false || strpos($key, 'instagram') !== false || strpos($key, 'facebook') !== false || strpos($key, 'youtube') !== false || $key === 'n8n_webhook_url') {
            $sanitized[$key] = esc_url_raw($value);
        } elseif ($key === 'footer_maps_embed') {
            // Allow iframe for Google Maps embed
            $sanitized[$key] = wp_kses($value, array(
                'iframe' => array(
                    'src' => true,
                    'width' => true,
                    'height' => true,
                    'style' => true,
                    'allowfullscreen' => true,
                    'loading' => true,
                    'referrerpolicy' => true,
                    'frameborder' => true,
                )
            ));
        } elseif ($key === 'sekolah_visi' || $key === 'sekolah_misi') {
            $sanitized[$key] = wp_kses_post($value);
        } elseif ($key === 'n8n_enabled') {
            $sanitized[$key] = $value === '1' ? '1' : '0';
        } elseif ($key === 'n8n_timeout') {
            $sanitized[$key] = absint($value);
        } else {
            $sanitized[$key] = sanitize_text_field($value);
        }
    }
    return $sanitized;
}

/**
 * Settings Page HTML
 */
function websiteku_settings_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        add_settings_error('websiteku_messages', 'websiteku_message', 'Pengaturan berhasil disimpan! ✅', 'updated');
    }

    settings_errors('websiteku_messages');
    ?>
    <div class="wrap">
        <h1>
            <?php echo esc_html(get_admin_page_title()); ?>
        </h1>

        <div class="websiteku-settings-header"
            style="background: linear-gradient(135deg, #2E7D32, #00838F); color: white; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h2 style="color: white; margin: 0;">⚙️ Pengaturan Tema Websiteku</h2>
            <p style="opacity: 0.9; margin: 5px 0 0;">Kelola semua pengaturan website TIK dari sini</p>
        </div>

        <form action="options.php" method="post">
            <?php
            settings_fields('websiteku_settings');
            do_settings_sections('websiteku-settings');
            submit_button('Simpan Pengaturan');
            ?>
        </form>
    </div>

    <style>
        .form-table th {
            width: 200px;
        }

        .form-table td input.regular-text,
        .form-table td textarea {
            width: 100%;
            max-width: 500px;
        }

        h2 {
            margin-top: 30px !important;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        h2:first-of-type {
            border-top: none;
        }
    </style>
    <?php
}

/**
 * Helper function to get theme option
 */
function websiteku_get_option($key, $default = '')
{
    $options = get_option('websiteku_options', []);
    return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * Enqueue admin scripts for media uploader
 */
function websiteku_admin_scripts($hook)
{
    if ($hook !== 'toplevel_page_websiteku-settings') {
        return;
    }

    wp_enqueue_media();

    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            // Upload image
            $(".upload-image-btn").on("click", function(e) {
                e.preventDefault();
                var field = $(this).data("field");
                var mediaUploader = wp.media({
                    title: "Pilih Logo",
                    button: { text: "Gunakan Gambar Ini" },
                    library: { type: "image" },
                    multiple: false
                });
                
                mediaUploader.on("select", function() {
                    var attachment = mediaUploader.state().get("selection").first().toJSON();
                    $("#" + field).val(attachment.url);
                    $("#" + field + "_preview").html("<img src=\"" + attachment.url + "\" style=\"max-width: 200px; height: auto; border-radius: 8px;\">");
                    $(".remove-image-btn[data-field=\"" + field + "\"]").show();
                });
                
                mediaUploader.open();
            });
            
            // Remove image
            $(".remove-image-btn").on("click", function(e) {
                e.preventDefault();
                var field = $(this).data("field");
                $("#" + field).val("");
                $("#" + field + "_preview").html("");
                $(this).hide();
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'websiteku_admin_scripts');
