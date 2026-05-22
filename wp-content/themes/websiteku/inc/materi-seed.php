<?php
/**
 * Impor materi TIK contoh (konten nyata untuk demo & skripsi)
 *
 * @package Websiteku
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data materi contoh per kelas.
 */
function websiteku_get_seed_materi_data()
{
    $ref = websiteku_get_tp_referensi_kelas();

    return array(
        array(
            'title' => 'Mengenal Komputer di Sekolah',
            'kelas' => '1',
            'bab' => 1,
            'icon' => 'fa-desktop',
            'quiz_id' => 'pengenalan-komputer',
            'video' => 'https://www.youtube.com/watch?v=2ePf9rue1Ao',
            'content' => '<p>Pada bab ini siswa mengenal komputer sebagai alat bantu belajar di SDIT Global Insan Madani. Materi disajikan dengan bahasa sederhana dan contoh di lingkungan sekolah.</p><ul><li>Bagian utama komputer</li><li>Cara menyalakan dan mematikan dengan benar</li><li>Aturan keselamatan di lab komputer</li></ul>',
            'tp' => $ref['1'],
        ),
        array(
            'title' => 'Keyboard, Mouse, dan Etika Digital',
            'kelas' => '2',
            'bab' => 1,
            'icon' => 'fa-keyboard',
            'quiz_id' => 'hardware',
            'video' => 'https://www.youtube.com/watch?v=O3QI47qHd18',
            'content' => '<p>Siswa berlatih menggunakan keyboard dan mouse serta memahami etika dasar saat menggunakan perangkat di sekolah.</p>',
            'tp' => $ref['2'],
        ),
        array(
            'title' => 'Menyimpan File dan Folder',
            'kelas' => '3',
            'bab' => 1,
            'icon' => 'fa-folder',
            'quiz_id' => 'software',
            'video' => 'https://www.youtube.com/watch?v=HB4MRcTQJWs',
            'content' => '<p>Materi tentang membuat folder, menyimpan dokumen, dan membuka kembali file tugas dengan rapi.</p>',
            'tp' => $ref['3'],
        ),
        array(
            'title' => 'Internet untuk Belajar',
            'kelas' => '4',
            'bab' => 1,
            'icon' => 'fa-globe',
            'quiz_id' => 'internet',
            'video' => 'https://www.youtube.com/watch?v=Dxcc6ycZ73E',
            'content' => '<p>Siswa mempelajari penggunaan internet untuk mendukung pembelajaran, keamanan sandi, dan membedakan informasi yang layak dipercaya.</p>',
            'tp' => $ref['4'],
        ),
        array(
            'title' => 'Pengolah Kata untuk Tugas',
            'kelas' => '5',
            'bab' => 1,
            'icon' => 'fa-file-lines',
            'quiz_id' => '',
            'video' => 'https://www.youtube.com/watch?v=1TO2dFqo4Mg',
            'content' => '<p>Pembelajaran membuat dokumen tugas dengan pengolah kata: judul, paragraf, dan format teks sederhana.</p>',
            'tp' => $ref['5'],
        ),
        array(
            'title' => 'Presentasi Digital Kelas 6',
            'kelas' => '6',
            'bab' => 1,
            'icon' => 'fa-display',
            'quiz_id' => '',
            'video' => 'https://www.youtube.com/watch?v=Cq_UG1mhSco',
            'content' => '<p>Siswa kelas 6 membuat slide presentasi bertema pelajaran dan mempresentasikan hasil karya secara mandiri.</p>',
            'tp' => $ref['6'],
        ),
        array(
            'title' => 'Keamanan Digital dan Privasi',
            'kelas' => '5',
            'bab' => 2,
            'icon' => 'fa-shield-alt',
            'quiz_id' => '',
            'video' => 'https://www.youtube.com/watch?v=z0M7bTEhTCs',
            'content' => '<p>Materi lanjutan tentang password, privasi data, dan perilaku aman di dunia maya.</p>',
            'tp' => array(
                'Mengidentifikasi ancaman digital sederhana (phishing, password lemah).',
                'Menerapkan kebiasaan membuat password yang kuat.',
                'Menjaga data pribadi saat berinternet.',
            ),
        ),
        array(
            'title' => 'Spreadsheet: Tabel dan Grafik Sederhana',
            'kelas' => '6',
            'bab' => 2,
            'icon' => 'fa-table',
            'quiz_id' => '',
            'video' => 'https://www.youtube.com/watch?v=8J3F2g5bPN4',
            'content' => '<p>Siswa mengolah data dalam tabel dan membuat grafik sederhana menggunakan aplikasi spreadsheet.</p>',
            'tp' => array(
                'Memasukkan data ke dalam sel spreadsheet.',
                'Membuat grafik dari data sederhana.',
                'Membaca dan menafsirkan grafik hasil karya sendiri.',
            ),
        ),
    );
}

/**
 * Jalankan impor materi.
 */
function websiteku_run_materi_seed($force = false)
{
    if (!$force && get_option('websiteku_materi_seeded') === '1') {
        return array('skipped' => true, 'message' => 'Materi contoh sudah pernah diimpor.');
    }

    $created = 0;
    $skipped = 0;

    foreach (websiteku_get_seed_materi_data() as $item) {
        $exists = get_posts(array(
            'post_type' => 'materi',
            'title' => $item['title'],
            'posts_per_page' => 1,
            'post_status' => 'any',
        ));

        if (!empty($exists) && !$force) {
            $skipped++;
            continue;
        }

        $post_id = wp_insert_post(array(
            'post_type' => 'materi',
            'post_title' => $item['title'],
            'post_content' => $item['content'],
            'post_excerpt' => wp_trim_words(wp_strip_all_tags($item['content']), 25),
            'post_status' => 'publish',
        ), true);

        if (is_wp_error($post_id)) {
            continue;
        }

        update_post_meta($post_id, '_materi_kelas', $item['kelas']);
        update_post_meta($post_id, '_materi_bab', $item['bab']);
        update_post_meta($post_id, '_materi_icon', $item['icon']);
        update_post_meta($post_id, '_materi_quiz_id', $item['quiz_id']);
        update_post_meta($post_id, '_materi_video_url', esc_url_raw($item['video']));
        update_post_meta($post_id, '_materi_active', '1');
        update_post_meta($post_id, '_materi_tp', implode("\n", $item['tp']));

        $created++;
    }

    update_option('websiteku_materi_seeded', '1');

    return array(
        'created' => $created,
        'skipped' => $skipped,
        'message' => sprintf('%d materi diimpor, %d dilewati (judul sudah ada).', $created, $skipped),
    );
}

/**
 * Menu admin impor materi.
 */
function websiteku_materi_seed_admin_menu()
{
    add_submenu_page(
        'edit.php?post_type=materi',
        'Impor Materi Contoh',
        'Impor Materi Contoh',
        'manage_options',
        'websiteku-materi-seed',
        'websiteku_materi_seed_admin_page'
    );
}
add_action('admin_menu', 'websiteku_materi_seed_admin_menu');

function websiteku_materi_seed_admin_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $result = null;
    if (isset($_POST['websiteku_run_seed']) && check_admin_referer('websiteku_materi_seed')) {
        $force = !empty($_POST['force_seed']);
        $result = websiteku_run_materi_seed($force);
    }

    $count = wp_count_posts('materi')->publish ?? 0;
    ?>
    <div class="wrap">
        <h1>Impor Materi TIK Contoh</h1>
        <p>Mengisi <strong><?php echo count(websiteku_get_seed_materi_data()); ?> materi</strong> per kelas dengan TP, konten, dan URL video (untuk demo skripsi).</p>
        <p>Materi published saat ini: <strong><?php echo esc_html($count); ?></strong></p>

        <?php if ($result): ?>
            <div class="notice notice-success">
                <p><?php echo esc_html($result['message']); ?></p>
            </div>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field('websiteku_materi_seed'); ?>
            <p>
                <label>
                    <input type="checkbox" name="force_seed" value="1">
                    Paksa impor ulang (buat duplikat jika judul sama akan dilewati)
                </label>
            </p>
            <button type="submit" name="websiteku_run_seed" class="button button-primary button-hero">
                Impor Materi Contoh Sekarang
            </button>
        </form>
    </div>
    <?php
}

/**
 * Jumlah materi published.
 */
function websiteku_materi_published_count()
{
    $counts = wp_count_posts('materi');
    return isset($counts->publish) ? (int) $counts->publish : 0;
}
