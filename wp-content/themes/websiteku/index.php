<?php
/**
 * Homepage Template
 * 
 * @package Websiteku
 */

get_header();

// Get theme settings
$hero_badge = websiteku_get_option('hero_badge', 'Pembelajaran Interaktif');
$hero_title = websiteku_get_option('hero_title', 'Belajar TIK Jadi Menyenangkan!');
$hero_subtitle = websiteku_get_option('hero_subtitle', 'Selamat datang di portal pembelajaran Teknologi Informasi & Komunikasi SDIT Global Insan Madani. Mari belajar bersama!');
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-shapes">
        <div class="hero-shape"></div>
        <div class="hero-shape"></div>
        <div class="hero-shape"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge"><i class="fas fa-desktop"></i> <?php echo esc_html($hero_badge); ?></span>
            <h1><?php echo esc_html($hero_title); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <div class="hero-buttons">
                <a href="#materi" class="btn btn-primary"><i class="fas fa-book"></i> Mulai Belajar</a>
                <button class="btn btn-outline" onclick="openChatbot()"><i class="fas fa-comments"></i> Tanya
                    Chatbot</button>
            </div>
        </div>
    </div>
</section>

<!-- Info Mapel Section -->
<section class="info-mapel" id="tentang">
    <div class="container">
        <div class="section-header">
            <h2>Tentang Mapel TIK</h2>
            <p>Teknologi Informasi & Komunikasi merupakan salah satu mata pelajaran penting di era digital</p>
        </div>

        <?php
        // Get info cards from settings
        $cards = array(
            1 => array(
                'icon' => websiteku_get_option('mapel_card1_icon', 'fa-bullseye'),
                'title' => websiteku_get_option('mapel_card1_title', 'Tujuan Pembelajaran'),
                'desc' => websiteku_get_option('mapel_card1_desc', 'Membekali siswa dengan pengetahuan dan keterampilan dasar dalam menggunakan teknologi informasi secara bijak dan bertanggung jawab.')
            ),
            2 => array(
                'icon' => websiteku_get_option('mapel_card2_icon', 'fa-lightbulb'),
                'title' => websiteku_get_option('mapel_card2_title', 'Kompetensi Dasar'),
                'desc' => websiteku_get_option('mapel_card2_desc', 'Mengenal perangkat keras & lunak komputer, memahami cara kerja internet, dan menerapkan keamanan digital.')
            ),
            3 => array(
                'icon' => websiteku_get_option('mapel_card3_icon', 'fa-book-open'),
                'title' => websiteku_get_option('mapel_card3_title', 'Metode Pembelajaran'),
                'desc' => websiteku_get_option('mapel_card3_desc', 'Pembelajaran interaktif dengan praktik langsung, diskusi kelompok, dan bantuan chatbot untuk tanya jawab materi.')
            ),
            4 => array(
                'icon' => websiteku_get_option('mapel_card4_icon', 'fa-trophy'),
                'title' => websiteku_get_option('mapel_card4_title', 'Target Capaian'),
                'desc' => websiteku_get_option('mapel_card4_desc', 'Siswa mampu mengoperasikan komputer, menggunakan aplikasi produktivitas, dan memahami etika digital.')
            )
        );
        ?>

        <div class="info-grid">
            <?php foreach ($cards as $card): ?>
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas <?php echo esc_attr($card['icon']); ?>"></i></div>
                    <h3>
                        <?php echo esc_html($card['title']); ?>
                    </h3>
                    <p>
                        <?php echo esc_html($card['desc']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="visi-misi-section" style="background: var(--gray-50); padding: 60px 0;">
    <div class="container">
        <div class="section-header">
            <h2>Visi & Misi Sekolah</h2>
            <p>Arah dan tujuan SDIT Global Insan Madani</p>
        </div>
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

<?php get_template_part('template-parts/materi', 'section'); ?>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2><i class="fas fa-question-circle"></i> Punya Pertanyaan?</h2>
        <p>Tanyakan langsung ke chatbot kami! Chatbot akan membantu menjawab pertanyaan seputar materi TIK.</p>
        <button class="btn" onclick="openChatbot()"><i class="fas fa-robot"></i> Buka Chatbot</button>
    </div>
</section>

<style>
    /* Visi Misi Styles (for Home) */
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
        color: var(--primary-green);
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

    @media (max-width: 768px) {
        .visi-misi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php get_footer(); ?>