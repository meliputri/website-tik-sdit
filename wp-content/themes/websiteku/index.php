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

<!-- Materi Section -->
<section class="materi-section" id="materi">
    <div class="container">
        <div class="section-header">
            <h2>Materi Pembelajaran</h2>
            <p>Daftar materi TIK yang akan kamu pelajari</p>
        </div>

        <!-- Search Bar -->
        <div class="materi-search">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="materi-search-input" placeholder="Cari materi..." autocomplete="off">
                <button type="button" id="materi-search-clear" class="search-clear" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="materi-search-count" class="search-count"></div>
        </div>

        <div class="materi-grid" id="materi-grid">
            <?php
            // Get materi from Custom Post Type
            $materi_query = websiteku_get_materi();

            if ($materi_query->have_posts()):
                while ($materi_query->have_posts()):
                    $materi_query->the_post();
                    $bab = get_post_meta(get_the_ID(), '_materi_bab', true);
                    $icon = get_post_meta(get_the_ID(), '_materi_icon', true) ?: 'fa-book';
                    $quiz_id = get_post_meta(get_the_ID(), '_materi_quiz_id', true);
                    $pdf_url = get_post_meta(get_the_ID(), '_materi_pdf_url', true);
                    ?>
                    <article class="materi-card">
                        <div class="materi-card-image"><i class="fas <?php echo esc_attr($icon); ?>"></i></div>
                        <div class="materi-card-content">
                            <span class="materi-card-badge">Bab <?php echo esc_html($bab); ?></span>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <div class="materi-card-actions">
                                <?php if ($pdf_url): ?>
                                    <a href="<?php echo esc_url($pdf_url); ?>" class="btn btn-outline" download>
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-outline" disabled><i class="fas fa-download"></i> PDF Belum Ada</button>
                                <?php endif; ?>

                                <?php if ($quiz_id): ?>
                                    <button class="btn btn-primary" onclick="openQuiz('<?php echo esc_js($quiz_id); ?>')"><i
                                            class="fas fa-pen"></i> Quiz</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled><i class="fas fa-clock"></i> Segera</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                ?>
                <!-- Default Materi -->
                <article class="materi-card">
                    <div class="materi-card-image"><i class="fas fa-desktop"></i></div>
                    <div class="materi-card-content">
                        <span class="materi-card-badge">Bab 1</span>
                        <h3>Pengenalan Komputer</h3>
                        <p>Mengenal apa itu komputer, sejarah perkembangannya, dan jenis-jenis komputer yang ada.</p>
                        <div class="materi-card-actions">
                            <a href="#" class="btn btn-outline"><i class="fas fa-download"></i> Download PDF</a>
                            <button class="btn btn-primary" onclick="openQuiz('pengenalan-komputer')"><i
                                    class="fas fa-pen"></i> Quiz</button>
                        </div>
                    </div>
                </article>

                <article class="materi-card">
                    <div class="materi-card-image"><i class="fas fa-keyboard"></i></div>
                    <div class="materi-card-content">
                        <span class="materi-card-badge">Bab 2</span>
                        <h3>Perangkat Keras (Hardware)</h3>
                        <p>Memahami komponen fisik komputer seperti CPU, monitor, keyboard, mouse, dan lainnya.</p>
                        <div class="materi-card-actions">
                            <a href="#" class="btn btn-outline"><i class="fas fa-download"></i> Download PDF</a>
                            <button class="btn btn-primary" onclick="openQuiz('hardware')"><i class="fas fa-pen"></i>
                                Quiz</button>
                        </div>
                    </div>
                </article>

                <article class="materi-card">
                    <div class="materi-card-image"><i class="fas fa-compact-disc"></i></div>
                    <div class="materi-card-content">
                        <span class="materi-card-badge">Bab 3</span>
                        <h3>Perangkat Lunak (Software)</h3>
                        <p>Mengenal sistem operasi, aplikasi, dan berbagai jenis software yang digunakan sehari-hari.</p>
                        <div class="materi-card-actions">
                            <a href="#" class="btn btn-outline"><i class="fas fa-download"></i> Download PDF</a>
                            <button class="btn btn-primary" onclick="openQuiz('software')"><i class="fas fa-pen"></i>
                                Quiz</button>
                        </div>
                    </div>
                </article>

                <article class="materi-card">
                    <div class="materi-card-image"><i class="fas fa-globe"></i></div>
                    <div class="materi-card-content">
                        <span class="materi-card-badge">Bab 4</span>
                        <h3>Internet & Jaringan</h3>
                        <p>Memahami cara kerja internet, browser, email, dan komunikasi digital yang aman.</p>
                        <div class="materi-card-actions">
                            <a href="#" class="btn btn-outline"><i class="fas fa-download"></i> Download PDF</a>
                            <button class="btn btn-primary" onclick="openQuiz('internet')"><i class="fas fa-pen"></i>
                                Quiz</button>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>

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