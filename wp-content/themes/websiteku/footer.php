<?php
/**
 * Footer Template
 * 
 * @package Websiteku
 */

// Get theme settings
$school_name = websiteku_get_option('school_name', 'SDIT Global Insan Madani');
$school_tagline = websiteku_get_option('school_tagline', 'Sekolah Dasar Islam Terpadu');
$school_address = websiteku_get_option('school_address', 'Jl. Contoh Alamat No. 123, Kota');
$school_phone = websiteku_get_option('school_phone', '(021) xxxx-xxxx');
$school_email = websiteku_get_option('school_email', 'info@sditglobalinsanmadani.sch.id');
$footer_copyright = websiteku_get_option('footer_copyright', '© ' . date('Y') . ' SDIT Global Insan Madani. All rights reserved.');

// Social media
$social_instagram = websiteku_get_option('social_instagram', '');
$social_facebook = websiteku_get_option('social_facebook', '');
$social_youtube = websiteku_get_option('social_youtube', '');
$social_whatsapp = websiteku_get_option('social_whatsapp', '');
?>

<!-- Footer -->
<footer class="site-footer" id="kontak">
    <div class="container">
        <div class="footer-grid">
            <!-- School Info -->
            <div class="footer-section">
                <h4><?php echo esc_html($school_name); ?></h4>
                <p><?php echo esc_html($school_tagline); ?> yang mengintegrasikan ilmu pengetahuan dan teknologi dengan
                    nilai-nilai Islam.</p>

                <?php if ($social_instagram || $social_facebook || $social_youtube || $social_whatsapp): ?>
                    <div class="footer-social">
                        <?php if ($social_instagram): ?>
                            <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" title="Instagram"><i
                                    class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($social_facebook): ?>
                            <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" title="Facebook"><i
                                    class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ($social_youtube): ?>
                            <a href="<?php echo esc_url($social_youtube); ?>" target="_blank" title="YouTube"><i
                                    class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if ($social_whatsapp): ?>
                            <a href="https://wa.me/<?php echo esc_attr($social_whatsapp); ?>" target="_blank"
                                title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4>Menu</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="#materi"><i class="fas fa-book"></i> Materi TIK</a></li>
                    <li><a href="#tentang"><i class="fas fa-info-circle"></i> Tentang Mapel</a></li>
                    <li><a href="#kontak"><i class="fas fa-envelope"></i> Kontak</a></li>
                </ul>
            </div>

            <!-- Materi -->
            <div class="footer-section">
                <h4>Materi TIK</h4>
                <ul>
                    <li><a href="#"><i class="fas fa-desktop"></i> Pengenalan Komputer</a></li>
                    <li><a href="#"><i class="fas fa-keyboard"></i> Perangkat Keras</a></li>
                    <li><a href="#"><i class="fas fa-compact-disc"></i> Perangkat Lunak</a></li>
                    <li><a href="#"><i class="fas fa-globe"></i> Internet & Keamanan</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-section">
                <h4>Kontak</h4>
                <p>
                    <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($school_address); ?><br>
                    <i class="fas fa-phone"></i> <?php echo esc_html($school_phone); ?><br>
                    <i class="fas fa-envelope"></i> <?php echo esc_html($school_email); ?>
                </p>
            </div>
        </div>

        <?php
        $maps_embed = websiteku_get_option('footer_maps_embed', '');
        if ($maps_embed):
            ?>
            <!-- Google Maps -->
            <div class="footer-maps">
                <h4><i class="fas fa-map-marked-alt"></i> Lokasi Kami</h4>
                <div class="maps-container">
                    <?php echo $maps_embed; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-bottom">
            <p><?php echo esc_html($footer_copyright); ?></p>
        </div>
    </div>
</footer>

<style>
    .footer-social {
        margin-top: 15px;
        display: flex;
        gap: 12px;
    }

    .footer-social a {
        font-size: 1.3rem;
        color: var(--gray-400);
        transition: all 0.3s ease;
    }

    .footer-social a:hover {
        color: var(--white);
        transform: scale(1.2);
    }

    .footer-section ul li a i {
        width: 20px;
        margin-right: 5px;
    }

    .footer-section p i {
        width: 20px;
        margin-right: 5px;
    }

    /* Footer Maps */
    .footer-maps {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-maps h4 {
        color: var(--white);
        margin-bottom: 15px;
    }

    .footer-maps h4 i {
        margin-right: 8px;
    }

    .maps-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .maps-container iframe {
        width: 100%;
        height: 250px;
        border: none;
        display: block;
    }
</style>

<!-- Leaderboard Floating Button -->
<button class="leaderboard-toggle" onclick="toggleLeaderboard()">
    <i class="fas fa-trophy"></i>
    <span>Papan Peringkat</span>
</button>

<!-- Leaderboard Modal -->
<div id="leaderboard-modal" class="leaderboard-modal">
    <div class="leaderboard-content">
        <button class="leaderboard-close" onclick="toggleLeaderboard()">&times;</button>
        <div class="leaderboard-header">
            <i class="fas fa-trophy" style="font-size: 3rem; color: #FFD700; margin-bottom: 15px;"></i>
            <h2>Papan Peringkat TIK</h2>
            <p>10 Siswa dengan Nilai Tertinggi</p>
        </div>
        <div class="leaderboard-body" id="leaderboard-list">
            <div style="text-align: center; padding: 20px;">
                <i class="fas fa-spinner fa-spin"></i> Memuat data...
            </div>
        </div>
    </div>
</div>

<style>
    /* Leaderboard Toggle Button */
    .leaderboard-toggle {
        position: fixed;
        left: 20px;
        bottom: 20px;
        background: linear-gradient(135deg, #FF9800, #F57C00);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
        z-index: 999;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .leaderboard-toggle:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(255, 152, 0, 0.6);
    }

    /* Leaderboard Modal */
    .leaderboard-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
    }

    .leaderboard-modal.active {
        display: flex;
    }

    .leaderboard-content {
        background: white;
        width: 90%;
        max-width: 500px;
        border-radius: 20px;
        padding: 30px;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease-out;
    }

    .leaderboard-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        font-size: 28px;
        color: #999;
        cursor: pointer;
        transition: color 0.3s;
    }

    .leaderboard-close:hover {
        color: #e74c3c;
    }

    .leaderboard-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px dashed #eee;
    }

    .leaderboard-header h2 {
        color: #333;
        margin: 0 0 5px 0;
    }

    .leaderboard-header p {
        color: #666;
        margin: 0;
    }

    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 10px;
        transition: transform 0.2s;
    }

    .leaderboard-item:hover {
        transform: translateX(5px);
        background: #fff3e0;
    }

    .leaderboard-rank {
        width: 40px;
        height: 40px;
        background: #e0e0e0;
        color: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        margin-right: 15px;
    }

    .leaderboard-item.rank-1 .leaderboard-rank {
        background: #FFD700;
        color: #b8860b;
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
    }

    .leaderboard-item.rank-2 .leaderboard-rank {
        background: #C0C0C0;
        color: #696969;
    }

    .leaderboard-item.rank-3 .leaderboard-rank {
        background: #CD7F32;
        color: #8b4513;
    }

    .leaderboard-info {
        flex-grow: 1;
    }

    .leaderboard-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
        display: block;
    }

    .leaderboard-date {
        font-size: 12px;
        color: #888;
    }

    .leaderboard-score {
        font-size: 24px;
        font-weight: 700;
        color: #2E7D32;
    }
    
    @media (max-width: 768px) {
        .leaderboard-toggle span {
            display: none;
        }
        .leaderboard-toggle {
            padding: 15px;
            border-radius: 50%;
            bottom: 80px; /* Above mobile nav if any */
        }
    }
</style>

<script>
    function toggleLeaderboard() {
        const modal = document.getElementById('leaderboard-modal');
        if (modal.classList.contains('active')) {
            modal.classList.remove('active');
        } else {
            modal.classList.add('active');
            fetchLeaderboard();
        }
    }

    function fetchLeaderboard() {
        if (!websitekuN8nConfig || !websitekuN8nConfig.api_url) return;
        
        const listContainer = document.getElementById('leaderboard-list');
        listContainer.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>';

        fetch(websitekuN8nConfig.api_url + '?action=websiteku_get_leaderboard')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    let html = '';
                    data.data.forEach((item, index) => {
                        const rank = index + 1;
                        // Format date simple
                        const dateObj = new Date(item.date);
                        const dateStr = dateObj.toLocaleDateString('id-ID', {day: 'numeric', month: 'short'});
                        
                        html += `
                            <div class="leaderboard-item rank-${rank}">
                                <div class="leaderboard-rank">${rank}</div>
                                <div class="leaderboard-info">
                                    <span class="leaderboard-name">${item.name || 'Anonim'}</span>
                                    <span class="leaderboard-date">${dateStr}</span>
                                </div>
                                <div class="leaderboard-score">${item.score}</div>
                            </div>
                        `;
                    });
                    listContainer.innerHTML = html;
                } else {
                    listContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #888;">Belum ada data nilai kuis. Jadilah yang pertama!</div>';
                }
            })
            .catch(err => {
                console.error(err);
                listContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #e74c3c;">Gagal memuat papan peringkat.</div>';
            });
    }
</script>

<?php wp_footer(); ?>
</body>

</html>