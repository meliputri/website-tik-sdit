<?php
/**
 * Kartu materi TIK
 *
 * @package Websiteku
 * @var array $materi Item dari websiteku_format_materi_item atau sample.
 */

if (!defined('ABSPATH') || empty($materi)) {
    return;
}

$icon = $materi['icon'] ?? 'fa-book';
$bab = $materi['bab'] ?? '1';
$kelas = $materi['kelas'] ?? '1';
$kelas_label = $materi['kelas_label'] ?? ('Kelas ' . $kelas);
$tp_list = $materi['tp'] ?? array();
$quiz_id = $materi['quiz_id'] ?? '';
$pdf_url = $materi['pdf_url'] ?? '';
$video_url = $materi['video_url'] ?? '';
$permalink = $materi['permalink'] ?? '#';
$is_sample = !empty($materi['is_sample']);
?>
<article class="materi-card" data-kelas="<?php echo esc_attr($kelas); ?>"
    data-title="<?php echo esc_attr($materi['title']); ?>"
    data-tp="<?php echo esc_attr($materi['tp_text'] ?? implode(' ', $tp_list)); ?>">
    <div class="materi-card-image"><i class="fas <?php echo esc_attr($icon); ?>"></i></div>
    <div class="materi-card-content">
        <div class="materi-card-badges">
            <span class="materi-card-badge materi-badge-kelas"><?php echo esc_html($kelas_label); ?></span>
            <span class="materi-card-badge">Bab <?php echo esc_html($bab); ?></span>
            <?php if (!empty($video_url)): ?>
                <span class="materi-card-badge materi-badge-video"><i class="fas fa-play-circle"></i> Video</span>
            <?php endif; ?>
        </div>
        <h3><?php echo esc_html($materi['title']); ?></h3>
        <p><?php echo esc_html($materi['excerpt']); ?></p>
        <?php if (!empty($tp_list)): ?>
            <div class="materi-tp-preview">
                <strong><i class="fas fa-bullseye"></i> TP:</strong>
                <ul>
                    <?php foreach (array_slice($tp_list, 0, 2) as $tp): ?>
                        <li><?php echo esc_html(wp_trim_words($tp, 12)); ?></li>
                    <?php endforeach; ?>
                    <?php if (count($tp_list) > 2): ?>
                        <li class="materi-tp-more">+<?php echo count($tp_list) - 2; ?> TP lainnya</li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="materi-card-actions">
            <?php if (!$is_sample && $permalink !== '#'): ?>
                <a href="<?php echo esc_url($permalink); ?>" class="btn btn-outline"><i class="fas fa-book-open"></i> Detail</a>
            <?php endif; ?>
            <?php if ($pdf_url): ?>
                <a href="<?php echo esc_url($pdf_url); ?>" class="btn btn-outline" download><i class="fas fa-download"></i> PDF</a>
            <?php endif; ?>
            <?php if ($video_url): ?>
                <button type="button" class="btn btn-secondary btn-video-materi" data-video-url="<?php echo esc_attr($video_url); ?>"
                    data-title="<?php echo esc_attr($materi['title']); ?>">
                    <i class="fas fa-play"></i> Video
                </button>
            <?php endif; ?>
            <?php if ($quiz_id): ?>
                <button type="button" class="btn btn-primary" onclick="openQuiz('<?php echo esc_js($quiz_id); ?>')"><i
                        class="fas fa-pen"></i> Quiz</button>
            <?php else: ?>
                <button type="button" class="btn btn-secondary" disabled><i class="fas fa-clock"></i> Quiz</button>
            <?php endif; ?>
        </div>
    </div>
</article>
