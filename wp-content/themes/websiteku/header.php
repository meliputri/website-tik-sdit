<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Pembelajaran TIK SDIT Global Insan Madani">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php
    // Get theme settings for top bar
    $school_phone = websiteku_get_option('school_phone', '(021) xxxx-xxxx');
    $school_email = websiteku_get_option('school_email', 'info@sditglobalinsanmadani.sch.id');
    $school_address = websiteku_get_option('school_address', 'Jl. Contoh Alamat No. 123');
    $school_name = websiteku_get_option('school_name', 'SDIT Global Insan Madani');

    // Social media
    $social_instagram = websiteku_get_option('social_instagram', '');
    $social_facebook = websiteku_get_option('social_facebook', '');
    $social_whatsapp = websiteku_get_option('social_whatsapp', '');
    ?>

    <!-- Top Info Bar -->
    <div class="top-info-bar">
        <div class="container">
            <div class="top-info-left">
                <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($school_address); ?></span>
                <span><i class="fas fa-phone"></i> <?php echo esc_html($school_phone); ?></span>
                <span><i class="fas fa-envelope"></i> <?php echo esc_html($school_email); ?></span>
            </div>
            <div class="top-info-right">
                <?php if ($social_instagram): ?>
                    <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" title="Instagram"><i
                            class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if ($social_facebook): ?>
                    <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" title="Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if ($social_whatsapp): ?>
                    <a href="https://wa.me/<?php echo esc_attr($social_whatsapp); ?>" target="_blank" title="WhatsApp"><i
                            class="fab fa-whatsapp"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="site-header" id="site-header">
        <div class="container">
            <div class="header-inner">
                <!-- Logo -->
                <?php
                $site_logo = websiteku_get_option('site_logo', '');
                $logo_url = $site_logo ? $site_logo : websiteku_image('logo.png');
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Logo <?php echo esc_attr($school_name); ?>">
                    <div class="site-logo-text">
                        <?php echo esc_html($school_name); ?>
                        <span>Mapel TIK</span>
                    </div>
                </a>

                <!-- Navigation -->
                <nav class="main-nav" id="main-nav">
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"
                                class="<?php echo is_front_page() ? 'active' : ''; ?>">Beranda</a></li>
                        <li><a href="<?php echo esc_url(get_post_type_archive_link('materi') ?: home_url('/#materi')); ?>">Materi</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </nav>

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" id="menu-toggle" aria-label="Toggle Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>