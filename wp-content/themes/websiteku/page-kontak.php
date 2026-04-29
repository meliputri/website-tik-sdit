<?php
/**
 * Template Name: Kontak
 * 
 * Template untuk halaman Kontak
 * 
 * @package Websiteku
 */

get_header();
?>

<main class="page-kontak">
    <!-- Page Header -->
    <section class="page-hero">
        <div class="container">
            <h1>
                <?php the_title(); ?>
            </h1>
            <p class="page-hero-subtitle">Hubungi kami untuk informasi lebih lanjut</p>
        </div>
    </section>

    <!-- Kontak Section -->
    <section class="kontak-section">
        <div class="container">
            <div class="kontak-grid">
                <!-- Info Kontak -->
                <div class="kontak-info">
                    <h2>Informasi Kontak</h2>
                    <p>Silakan hubungi kami melalui salah satu channel berikut:</p>

                    <div class="kontak-items">
                        <div class="kontak-item">
                            <span class="kontak-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <div>
                                <h4>Alamat</h4>
                                <p>Jl. Contoh Alamat No. 123<br>Kota, Provinsi 12345</p>
                            </div>
                        </div>

                        <div class="kontak-item">
                            <span class="kontak-icon"><i class="fas fa-phone"></i></span>
                            <div>
                                <h4>Telepon</h4>
                                <p>(021) xxxx-xxxx</p>
                            </div>
                        </div>

                        <div class="kontak-item">
                            <span class="kontak-icon"><i class="fas fa-envelope"></i></span>
                            <div>
                                <h4>Email</h4>
                                <p>info@sditglobalinsanmadani.sch.id</p>
                            </div>
                        </div>

                        <div class="kontak-item">
                            <span class="kontak-icon"><i class="fas fa-clock"></i></span>
                            <div>
                                <h4>Jam Operasional</h4>
                                <p>Senin - Jumat: 07:00 - 15:00<br>Sabtu: 07:00 - 12:00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="kontak-social">
                        <h4>Ikuti Kami</h4>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-link" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Form Kontak -->
                <div class="kontak-form-wrapper">
                    <h2>Kirim Pesan</h2>
                    <p>Ada pertanyaan? Isi form di bawah ini.</p>

                    <form class="kontak-form" id="kontak-form">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" required placeholder="Masukkan nama Anda">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required placeholder="Masukkan email Anda">
                        </div>

                        <div class="form-group">
                            <label for="subjek">Subjek</label>
                            <select id="subjek" name="subjek" required>
                                <option value="">Pilih subjek</option>
                                <option value="informasi">Informasi Umum</option>
                                <option value="pendaftaran">Pendaftaran Siswa</option>
                                <option value="kerja-sama">Kerja Sama</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pesan">Pesan</label>
                            <textarea id="pesan" name="pesan" rows="5" required
                                placeholder="Tulis pesan Anda"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim
                            Pesan</button>
                    </form>

                    <div class="form-note">
                        <p>* Form ini adalah tampilan demo. Untuk form fungsional, integrasikan dengan plugin Contact
                            Form 7 atau WPForms.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="section-header">
                <h2>Lokasi Kami</h2>
                <p>Kunjungi sekolah kami di alamat berikut</p>
            </div>
            <div class="map-placeholder">
                <span><i class="fas fa-map"></i></span>
                <p>Google Maps akan ditampilkan di sini</p>
                <small>Ganti dengan embed Google Maps dari wp-admin atau gunakan plugin</small>
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

    /* Kontak Section */
    .kontak-section {
        padding: 60px 0;
    }

    .kontak-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
    }

    /* Kontak Info */
    .kontak-info h2 {
        color: var(--primary-green);
        margin-bottom: 10px;
    }

    .kontak-info>p {
        color: var(--gray-600);
        margin-bottom: 30px;
    }

    .kontak-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .kontak-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .kontak-icon {
        font-size: 1.5rem;
        padding: 12px;
        background: rgba(46, 125, 50, 0.1);
        border-radius: 10px;
    }

    .kontak-item h4 {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .kontak-item p {
        color: var(--gray-600);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Social */
    .kontak-social {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid var(--gray-200);
    }

    .kontak-social h4 {
        margin-bottom: 15px;
    }

    .social-links {
        display: flex;
        gap: 10px;
    }

    .social-link {
        font-size: 1.5rem;
        padding: 10px;
        background: var(--gray-100);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--primary-green);
        transform: translateY(-3px);
    }

    /* Form */
    .kontak-form-wrapper {
        background: var(--gray-50);
        padding: 40px;
        border-radius: 15px;
    }

    .kontak-form-wrapper h2 {
        color: var(--primary-green);
        margin-bottom: 5px;
    }

    .kontak-form-wrapper>p {
        color: var(--gray-600);
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 1rem;
        font-family: inherit;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-green);
    }

    .kontak-form .btn {
        width: 100%;
        padding: 15px;
        font-size: 1rem;
    }

    .form-note {
        margin-top: 20px;
        padding: 15px;
        background: #fff3cd;
        border-radius: 8px;
    }

    .form-note p {
        font-size: 0.85rem;
        color: #856404;
        margin: 0;
    }

    /* Map */
    .map-section {
        background: var(--gray-50);
        padding: 60px 0;
    }

    .map-placeholder {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-blue));
        border-radius: 15px;
        padding: 80px;
        text-align: center;
        color: white;
    }

    .map-placeholder span {
        font-size: 4rem;
        display: block;
        margin-bottom: 15px;
    }

    .map-placeholder p {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .map-placeholder small {
        opacity: 0.8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .kontak-grid {
            grid-template-columns: 1fr;
        }

        .kontak-form-wrapper {
            padding: 25px;
        }

        .page-hero h1 {
            font-size: 1.8rem;
        }
    }
</style>

<script>
    // Form submit handler (demo)
    document.getElementById('kontak-form').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Terima kasih! Pesan Anda telah dikirim. (Ini hanya demo, untuk fungsional gunakan plugin form.)');
        this.reset();
    });
</script>

<?php get_footer(); ?>