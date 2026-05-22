<?php
/**
 * Section daftar materi TIK (beranda & arsip /materi)
 *
 * @package Websiteku
 */

$section_title = $args['title'] ?? 'Materi Pembelajaran TIK';
$section_subtitle = $args['subtitle'] ?? 'Materi disusun per kelas sesuai Tujuan Pembelajaran (TP) dan dilengkapi video animasi';
$section_id = $args['section_id'] ?? 'materi';
$show_sample_notice = $args['show_sample_notice'] ?? true;
?>
<section class="materi-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container">
        <div class="section-header">
            <h2><?php echo esc_html($section_title); ?></h2>
            <p><?php echo wp_kses_post($section_subtitle); ?></p>
        </div>

        <div class="materi-kelas-filter" id="materi-kelas-filter" role="tablist">
            <button type="button" class="kelas-tab active" data-kelas="all" role="tab">Semua Kelas</button>
            <?php foreach (websiteku_get_kelas_options() as $val => $label): ?>
                <button type="button" class="kelas-tab" data-kelas="<?php echo esc_attr($val); ?>" role="tab">
                    <?php echo esc_html($label); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="materi-tp-kelas-info" id="materi-tp-kelas-info" aria-live="polite"></div>

        <div class="materi-search">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="materi-search-input" placeholder="Cari materi, TP, atau bab..." autocomplete="off">
                <button type="button" id="materi-search-clear" class="search-clear" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="materi-search-count" class="search-count"></div>
        </div>

        <div class="materi-grid" id="materi-grid">
            <?php
            $materi_items = websiteku_get_materi_items();
            if (!empty($materi_items)):
                foreach ($materi_items as $materi):
                    include locate_template('template-parts/materi-card.php');
                endforeach;
            elseif ($show_sample_notice):
                foreach (websiteku_get_default_materi_samples() as $materi):
                    include locate_template('template-parts/materi-card.php');
                endforeach;
                ?>
                <p class="materi-sample-notice"><i class="fas fa-info-circle"></i> Contoh materi per kelas.
                    Klik <strong>Materi TIK → Impor Materi Contoh</strong> di admin untuk mengisi konten lengkap.</p>
            <?php else: ?>
                <p class="materi-sample-notice">Belum ada materi. Admin dapat menambah di Materi TIK.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<div id="materi-video-modal" class="materi-video-modal" aria-hidden="true">
    <div class="materi-video-modal-backdrop"></div>
    <div class="materi-video-modal-content">
        <button type="button" class="materi-video-close" aria-label="Tutup">&times;</button>
        <h3 id="materi-video-modal-title"></h3>
        <div id="materi-video-modal-embed"></div>
    </div>
</div>
