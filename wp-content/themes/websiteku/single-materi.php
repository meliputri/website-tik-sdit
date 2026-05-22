<?php
/**
 * Single Materi TIK
 *
 * @package Websiteku
 */

get_header();

while (have_posts()):
    the_post();
    $item = websiteku_format_materi_item(get_the_ID());
    $tp_list = $item['tp'];
    $video_embed = websiteku_get_video_embed_html($item['video_url']);
    ?>
    <main class="single-materi-page">
        <section class="page-hero materi-hero">
            <div class="container">
                <div class="materi-hero-badges">
                    <span class="materi-card-badge materi-badge-kelas"><?php echo esc_html($item['kelas_label']); ?></span>
                    <span class="materi-card-badge">Bab <?php echo esc_html($item['bab']); ?></span>
                </div>
                <h1><?php the_title(); ?></h1>
                <p class="page-hero-subtitle"><?php echo esc_html($item['excerpt']); ?></p>
            </div>
        </section>

        <section class="materi-detail-section">
            <div class="container materi-detail-grid">
                <div class="materi-detail-main">
                    <?php if ($video_embed): ?>
                        <div class="materi-video-block">
                            <h2><i class="fas fa-play-circle"></i> Video Animasi Pembelajaran</h2>
                            <?php echo $video_embed; ?>
                        </div>
                    <?php endif; ?>

                    <div class="materi-content-block">
                        <h2><i class="fas fa-book-open"></i> Materi</h2>
                        <div class="materi-entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php if (!empty($tp_list)): ?>
                        <div class="materi-tp-block">
                            <h2><i class="fas fa-bullseye"></i> Tujuan Pembelajaran (TP)</h2>
                            <ol class="materi-tp-list-full">
                                <?php foreach ($tp_list as $tp): ?>
                                    <li><?php echo esc_html($tp); ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="materi-detail-sidebar">
                    <div class="materi-sidebar-card">
                        <h3>Aksi Belajar</h3>
                        <?php if ($item['pdf_url']): ?>
                            <a href="<?php echo esc_url($item['pdf_url']); ?>" class="btn btn-outline btn-block" download>
                                <i class="fas fa-download"></i> Unduh PDF
                            </a>
                        <?php endif; ?>
                        <?php if ($item['quiz_id']): ?>
                            <button type="button" class="btn btn-primary btn-block"
                                onclick="openQuiz('<?php echo esc_js($item['quiz_id']); ?>')">
                                <i class="fas fa-pen"></i> Kerjakan Quiz
                            </button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary btn-block" onclick="openChatbotWithKelas(<?php echo esc_js($item['kelas']); ?>)">
                            <i class="fas fa-robot"></i> Tanya Chatbot
                        </button>
                        <a href="<?php echo esc_url(home_url('/#materi')); ?>" class="btn btn-outline btn-block">
                            <i class="fas fa-arrow-left"></i> Semua Materi
                        </a>
                    </div>
                </aside>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();
