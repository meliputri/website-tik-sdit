<?php
/**
 * Helper materi TIK: kelas, TP, video, konteks chatbot
 *
 * @package Websiteku
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Daftar kelas SD (1–6).
 */
function websiteku_get_kelas_options()
{
    return array(
        '1' => 'Kelas 1',
        '2' => 'Kelas 2',
        '3' => 'Kelas 3',
        '4' => 'Kelas 4',
        '5' => 'Kelas 5',
        '6' => 'Kelas 6',
    );
}

/**
 * Referensi TP Informatika/TIK per kelas (Kurikulum Merdeam — ringkas untuk panduan guru).
 */
function websiteku_get_tp_referensi_kelas()
{
    return array(
        '1' => array(
            'Mengenal perangkat teknologi di lingkungan sekolah dan rumah.',
            'Menjalankan aplikasi sederhana dengan bimbingan guru.',
            'Menunjukkan sikap aman saat menggunakan perangkat teknologi.',
        ),
        '2' => array(
            'Mengoperasikan perangkat teknologi untuk kegiatan belajar.',
            'Menggunakan aplikasi pembelajaran sesuai petunjuk.',
            'Menunjukkan etika dasar dalam menggunakan teknologi.',
        ),
        '3' => array(
            'Menggunakan perangkat dan aplikasi untuk menyimpan informasi sederhana.',
            'Mencari informasi terbatas dari sumber digital dengan bimbingan.',
            'Menerapkan kebiasaan aman saat berinteraksi di dunia digital.',
        ),
        '4' => array(
            'Mengolah data sederhana menggunakan aplikasi pengolah kata/tabel.',
            'Menggunakan internet untuk mendukung pembelajaran secara bertanggung jawab.',
            'Mengidentifikasi informasi yang layak dipercaya di internet.',
        ),
        '5' => array(
            'Menyusun dokumen digital dengan format yang rapi.',
            'Menggunakan spreadsheet untuk data dan grafik sederhana.',
            'Menerapkan etika dan keamanan digital dalam berkomunikasi online.',
        ),
        '6' => array(
            'Membuat presentasi digital untuk menyampaikan gagasan.',
            'Mengolah data menggunakan aplikasi spreadsheet dan presentasi.',
            'Menunjukkan literasi digital dalam memilih dan menggunakan informasi.',
        ),
    );
}

/**
 * Parse TP dari textarea (satu baris = satu TP).
 */
function websiteku_parse_tp_list($raw)
{
    if (empty($raw)) {
        return array();
    }
    $lines = preg_split('/\r\n|\r|\n/', $raw);
    $list = array();
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line !== '') {
            $list[] = $line;
        }
    }
    return $list;
}

/**
 * Embed video (YouTube / Vimeo) dari URL.
 */
function websiteku_get_video_embed_html($url)
{
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }

    $embed = '';
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
        $id = esc_attr($m[1]);
        $embed = '<div class="video-embed-wrap"><iframe src="https://www.youtube.com/embed/' . $id . '?rel=0" title="Video pembelajaran" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe></div>';
    } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
        $id = esc_attr($m[1]);
        $embed = '<div class="video-embed-wrap"><iframe src="https://player.vimeo.com/video/' . $id . '" title="Video pembelajaran" allowfullscreen loading="lazy"></iframe></div>';
    }

    return $embed;
}

/**
 * Data satu materi untuk template/JS.
 */
function websiteku_format_materi_item($post_id)
{
    $tp_raw = get_post_meta($post_id, '_materi_tp', true);
    $tp_list = websiteku_parse_tp_list($tp_raw);
    $kelas = get_post_meta($post_id, '_materi_kelas', true) ?: '1';
    $video_url = get_post_meta($post_id, '_materi_video_url', true);

    return array(
        'id' => $post_id,
        'slug' => get_post_field('post_name', $post_id),
        'title' => get_the_title($post_id),
        'excerpt' => wp_trim_words(get_post_field('post_excerpt', $post_id) ?: get_post_field('post_content', $post_id), 25),
        'bab' => get_post_meta($post_id, '_materi_bab', true),
        'icon' => get_post_meta($post_id, '_materi_icon', true) ?: 'fa-book',
        'kelas' => $kelas,
        'kelas_label' => websiteku_get_kelas_options()[$kelas] ?? 'Kelas ' . $kelas,
        'tp' => $tp_list,
        'tp_text' => implode(' ', $tp_list),
        'quiz_id' => get_post_meta($post_id, '_materi_quiz_id', true),
        'pdf_url' => get_post_meta($post_id, '_materi_pdf_url', true),
        'video_url' => $video_url,
        'has_video' => !empty($video_url),
        'permalink' => get_permalink($post_id),
    );
}

/**
 * Ambil semua materi aktif sebagai array.
 */
function websiteku_get_materi_items($kelas = null)
{
    $args = array();
    if ($kelas !== null && $kelas !== '' && $kelas !== 'all') {
        $args['meta_query'] = array(
            array(
                'key' => '_materi_kelas',
                'value' => sanitize_text_field($kelas),
                'compare' => '=',
            ),
        );
    }

    $query = websiteku_get_materi($args);
    $items = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $items[] = websiteku_format_materi_item(get_the_ID());
        }
        wp_reset_postdata();
    }

    return $items;
}

/**
 * Konteks materi untuk chatbot (rule-based & n8n).
 */
function websiteku_get_materi_chatbot_context($kelas = null)
{
    $items = websiteku_get_materi_items($kelas);
    $context = array();

    foreach ($items as $item) {
        $keywords = array(
            strtolower($item['title']),
            'kelas ' . $item['kelas'],
            'bab ' . $item['bab'],
        );
        foreach ($item['tp'] as $tp) {
            $keywords[] = strtolower(wp_trim_words($tp, 8, ''));
        }

        $answer = "**{$item['title']}** ({$item['kelas_label']}, Bab {$item['bab']})\n\n";
        if (!empty($item['tp'])) {
            $answer .= "**Tujuan Pembelajaran:**\n";
            foreach ($item['tp'] as $i => $tp) {
                $answer .= ($i + 1) . '. ' . $tp . "\n";
            }
            $answer .= "\n";
        }
        if (!empty($item['excerpt'])) {
            $answer .= $item['excerpt'] . "\n\n";
        }
        $answer .= "📖 Buka materi lengkap: {$item['permalink']}";
        if ($item['has_video']) {
            $answer .= "\n🎬 Materi ini memiliki video animasi pembelajaran.";
        }

        $context[] = array(
            'id' => $item['id'],
            'title' => $item['title'],
            'kelas' => $item['kelas'],
            'bab' => $item['bab'],
            'keywords' => array_values(array_filter(array_unique($keywords))),
            'answer' => $answer,
            'link' => $item['permalink'],
            'video_url' => $item['video_url'],
        );
    }

    return $context;
}

/**
 * Materi contoh per kelas jika belum ada di database.
 */
function websiteku_get_default_materi_samples()
{
    $samples = array(
        array('kelas' => '1', 'bab' => 1, 'icon' => 'fa-desktop', 'title' => 'Mengenal Komputer di Sekolah', 'tp' => "Mengenal perangkat komputer di lingkungan sekolah.\nMenunjukkan bagian utama komputer (monitor, keyboard, mouse).\nMenjalankan komputer dengan bimbingan guru.", 'quiz' => 'pengenalan-komputer'),
        array('kelas' => '2', 'bab' => 1, 'icon' => 'fa-keyboard', 'title' => 'Menggunakan Keyboard dan Mouse', 'tp' => "Mengoperasikan keyboard untuk mengetik huruf sederhana.\nMenggunakan mouse untuk klik dan drag.\nMenjaga postur tubuh saat menggunakan komputer.", 'quiz' => 'hardware'),
        array('kelas' => '3', 'bab' => 1, 'icon' => 'fa-folder', 'title' => 'Menyimpan File di Komputer', 'tp' => "Membuat folder untuk menyimpan tugas.\nMenyimpan dan membuka file dokumen.\nMenamai file dengan rapi dan bermakna.", 'quiz' => 'software'),
        array('kelas' => '4', 'bab' => 1, 'icon' => 'fa-globe', 'title' => 'Internet untuk Belajar', 'tp' => "Mengakses situs edukasi dengan bimbingan guru.\nMenggunakan mesin pencari untuk materi pelajaran.\nMembedakan informasi bermanfaat dan tidak pantas.", 'quiz' => 'internet'),
        array('kelas' => '5', 'bab' => 1, 'icon' => 'fa-file-lines', 'title' => 'Pengolah Kata Sederhana', 'tp' => "Membuat dokumen teks dengan judul dan paragraf.\nMemformat huruf, warna, dan jajaran teks.\nMencetak atau menyimpan tugas ke PDF.", 'quiz' => ''),
        array('kelas' => '6', 'bab' => 1, 'icon' => 'fa-display', 'title' => 'Presentasi Digital', 'tp' => "Membuat slide presentasi bertema pelajaran.\nMenambahkan gambar dan teks pada slide.\nMempresentasikan hasil karya secara mandiri.", 'quiz' => ''),
    );

    $out = array();
    foreach ($samples as $s) {
        $out[] = array(
            'id' => 0,
            'slug' => sanitize_title($s['title']),
            'title' => $s['title'],
            'excerpt' => wp_trim_words($s['tp'], 20),
            'bab' => $s['bab'],
            'icon' => $s['icon'],
            'kelas' => $s['kelas'],
            'kelas_label' => 'Kelas ' . $s['kelas'],
            'tp' => websiteku_parse_tp_list($s['tp']),
            'tp_text' => $s['tp'],
            'quiz_id' => $s['quiz'],
            'pdf_url' => '',
            'video_url' => '',
            'has_video' => false,
            'permalink' => '#materi',
            'is_sample' => true,
        );
    }
    return $out;
}
