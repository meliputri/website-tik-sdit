<?php
/**
 * Arsip Materi TIK — /materi/
 *
 * @package Websiteku
 */

get_header();
?>

<main class="archive-materi-page">
    <section class="page-hero materi-archive-hero">
        <div class="container">
            <h1>Materi TIK</h1>
            <p class="page-hero-subtitle">Katalog pembelajaran Teknologi Informasi & Komunikasi per kelas SD</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline" style="margin-top:1rem;color:#fff;border-color:#fff;">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </section>

    <?php
    get_template_part('template-parts/materi', 'section', array(
        'title' => 'Semua Materi Pembelajaran',
        'subtitle' => 'Pilih kelas, baca TP, tonton video animasi, unduh PDF, dan kerjakan quiz.',
        'section_id' => 'materi-katalog',
        'show_sample_notice' => true,
    ));
    ?>
</main>

<style>
    .archive-materi-page .materi-archive-hero {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-blue));
        color: var(--white);
        padding: 3rem 0;
        text-align: center;
    }

    .archive-materi-page .materi-archive-hero h1,
    .archive-materi-page .page-hero-subtitle {
        color: var(--white);
    }
</style>

<?php
get_footer();
