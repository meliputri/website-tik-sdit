<?php
/**
 * Template Name: Tentang Sekolah
 * 
 * Template untuk halaman Tentang Sekolah dengan Visi Misi
 * 
 * @package Websiteku
 */

get_header();
?>

<main class="page-tentang">
    <!-- Page Header -->
    <section class="page-hero">
        <div class="container">
            <h1>
                <?php the_title(); ?>
            </h1>
            <p class="page-hero-subtitle">Mengenal lebih dekat SDIT Global Insan Madani</p>
        </div>
    </section>

    <!-- Profil Sekolah -->
    <section class="tentang-section">
        <div class="container">
            <div class="tentang-grid">
                <div class="tentang-image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php else: ?>
                        <div class="tentang-image-placeholder">
                            <span><i class="fas fa-school"></i></span>
                            <p>Foto Sekolah</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tentang-content">
                    <h2>Profil Sekolah</h2>
                    <?php
                    while (have_posts()):
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="visi-misi-section">
        <div class="container">
        <?php
        $visi = websiteku_get_option('sekolah_visi', '<p>Menjadi lembaga pendidikan Islam terpadu yang unggul dalam IMTAQ dan IPTEK, menghasilkan generasi yang berakhlak mulia, cerdas, mandiri, dan berwawasan global.</p>');
        $misi = websiteku_get_option('sekolah_misi', "<ul><li>Menyelenggarakan pendidikan yang mengintegrasikan ilmu pengetahuan dan nilai-nilai Islam</li><li>Mengembangkan potensi siswa secara optimal dalam bidang akademik dan non-akademik</li><li>Membentuk karakter siswa yang berakhlak mulia dan bertanggung jawab</li><li>Membekali siswa dengan keterampilan teknologi informasi yang bermanfaat</li><li>Menciptakan lingkungan belajar yang kondusif, aman, dan nyaman</li></ul>");
        ?>
        <div class="visi-misi-grid">
            <div class="visi-card">
                <div class="visi-card-icon"><i class="fas fa-bullseye"></i></div>
                <h3>Visi</h3>
                <div class="visi-content"><?php echo wp_kses_post($visi); ?></div>
            </div>
            <div class="misi-card">
                <div class="misi-card-icon"><i class="fas fa-rocket"></i></div>
                <h3>Misi</h3>
                <div class="misi-content"><?php echo wp_kses_post($misi); ?></div>
            </div>
        </div>
        </div>
    </section>

    <!-- Fasilitas TIK -->
    <section class="fasilitas-section">
        <div class="container">
            <div class="section-header">
                <h2>Fasilitas Lab Komputer</h2>
                <p>Sarana dan prasarana pendukung pembelajaran TIK</p>
            </div>
            <div class="fasilitas-grid">
                <div class="fasilitas-card">
                    <span class="fasilitas-icon"><i class="fas fa-desktop"></i></span>
                    <h4>Komputer Terbaru</h4>
                    <p>Dilengkapi dengan PC modern untuk praktik siswa</p>
                </div>
                <div class="fasilitas-card">
                    <span class="fasilitas-icon"><i class="fas fa-globe"></i></span>
                    <h4>Internet Cepat</h4>
                    <p>Koneksi internet stabil untuk pembelajaran online</p>
                </div>
                <div class="fasilitas-card">
                    <span class="fasilitas-icon"><i class="fas fa-video"></i></span>
                    <h4>Proyektor</h4>
                    <p>Proyektor untuk presentasi dan demo materi</p>
                </div>
                <div class="fasilitas-card">
                    <span class="fasilitas-icon"><i class="fas fa-snowflake"></i></span>
                    <h4>Ruangan Nyaman</h4>
                    <p>Lab ber-AC dengan pencahayaan yang baik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Guru TIK -->
    <section class="guru-section">
        <div class="container">
            <div class="section-header">
                <h2>Guru Pengampu</h2>
                <p>Tenaga pendidik yang berkompeten di bidang TIK</p>
            </div>
            <div class="guru-grid">
                <div class="guru-card">
                    <div class="guru-avatar"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h4>Nama Guru</h4>
                    <p>Guru TIK</p>
                    <span class="guru-badge">S1 Teknik Informatika</span>
                </div>
                <!-- Tambahkan guru lainnya jika ada -->
            </div>
        </div>
    </section>
</main>

<style>
    /* Page Hero */
    .page-hero {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-blue));
        color: white;
        padding: 120px 0 60px;
        text-align: center;
    }

    .page-hero h1 {
        color: white;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .page-hero-subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    /* Tentang Section */
    .tentang-section {
        padding: 60px 0;
    }

    .tentang-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .tentang-image img {
        border-radius: 15px;
        box-shadow: var(--shadow-lg);
    }

    .tentang-image-placeholder {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-blue));
        border-radius: 15px;
        padding: 80px 40px;
        text-align: center;
        color: white;
    }

    .tentang-image-placeholder span {
        font-size: 5rem;
        display: block;
        margin-bottom: 10px;
    }

    .tentang-content h2 {
        margin-bottom: 20px;
        color: var(--primary-green);
    }

    /* Visi Misi */
    .visi-misi-section {
        background: var(--gray-50);
        padding: 60px 0;
    }

    .visi-misi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .visi-card,
    .misi-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: var(--shadow-md);
    }

    .visi-card-icon,
    .misi-card-icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .visi-card h3,
    .misi-card h3 {
        color: var(--primary-green);
        margin-bottom: 15px;
    }

    .misi-card ul {
        list-style: disc;
        padding-left: 20px;
    }

    .misi-card ul li {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .visi-card small,
    .misi-card small {
        display: block;
        margin-top: 15px;
        color: #999;
        font-size: 0.8rem;
    }

    /* Fasilitas */
    .fasilitas-section {
        padding: 60px 0;
    }

    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .fasilitas-card {
        background: white;
        padding: 30px 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        transition: transform 0.3s ease;
    }

    .fasilitas-card:hover {
        transform: translateY(-5px);
    }

    .fasilitas-icon {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 15px;
    }

    .fasilitas-card h4 {
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .fasilitas-card p {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Guru */
    .guru-section {
        background: var(--gray-50);
        padding: 60px 0;
    }

    .guru-grid {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .guru-card {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow-md);
        min-width: 200px;
    }

    .guru-avatar {
        font-size: 4rem;
        margin-bottom: 15px;
    }

    .guru-card h4 {
        margin-bottom: 5px;
    }

    .guru-card p {
        color: var(--gray-600);
        margin-bottom: 10px;
    }

    .guru-badge {
        display: inline-block;
        padding: 5px 12px;
        background: rgba(46, 125, 50, 0.1);
        color: var(--primary-green);
        border-radius: 20px;
        font-size: 0.8rem;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .tentang-grid,
        .visi-misi-grid {
            grid-template-columns: 1fr;
        }

        .fasilitas-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-hero h1 {
            font-size: 1.8rem;
        }
    }
</style>

<?php get_footer(); ?>