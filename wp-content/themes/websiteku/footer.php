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

<?php wp_footer(); ?>
</body>

</html>