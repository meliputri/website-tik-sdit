# WordPress Theme "Websiteku" - SDIT Global Insan Madani

Website edukasi TIK (Teknologi Informasi & Komunikasi) dengan chatbot rule-based untuk tanya jawab materi.

---

## Proposed Changes

### WordPress Theme Structure

#### [NEW] [style.css](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/style.css)

Theme stylesheet dengan branding sekolah:

- **Primary color**: Hijau (#2E7D32) - sesuai logo
- **Secondary color**: Biru/Teal (#00838F) - aksen
- **Typography**: Modern, readable untuk edukasi
- **Responsive design** untuk mobile & desktop

---

#### [NEW] [functions.php](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/functions.php)

Registrasi fitur tema:

- Enqueue styles & scripts
- Menu navigation
- Widget areas
- Custom post type untuk Materi TIK (opsional)

---

#### [NEW] [header.php](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/header.php)

Header dengan:

- Logo sekolah SDIT Global Insan Madani
- Navigation menu (Home, Materi, Tentang, Kontak)
- Responsive hamburger menu

---

#### [NEW] [footer.php](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/footer.php)

Footer dengan:

- Info sekolah
- Copyright
- Quick links

---

#### [NEW] [index.php](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/index.php)

Homepage dengan sections:

- Hero section dengan tagline TIK
- Daftar materi TIK
- CTA untuk chatbot
- Info mapel

---

#### [NEW] [page.php](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/page.php)

Template untuk halaman statis (Tentang, Kontak, dll)

---

### Chatbot Rule-Based

#### [NEW] [assets/js/chatbot.js](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/assets/js/chatbot.js)

Logic chatbot:

- UI widget floating di pojok kanan bawah
- Input field untuk pertanyaan
- Matching keyword dengan database jawaban
- Fallback response jika tidak ada match

---

#### [NEW] [assets/js/chatbot-data.js](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/assets/js/chatbot-data.js)

Database Q&A chatbot dalam format JavaScript object.

> [!NOTE]
> File ini nanti bisa diisi dengan materi TIK dari user. Saya akan buatkan contoh struktur dan beberapa sample Q&A.

---

#### [NEW] [assets/css/chatbot.css](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/assets/css/chatbot.css)

Styling untuk chatbot widget dengan warna matching tema sekolah.

---

### Assets

#### [NEW] [screenshot.png](file:///c:/laragon/www/websiteku/wp-content/themes/websiteku/screenshot.png)

Preview tema untuk dashboard WordPress.

---

## Verification Plan

### Manual Testing

Setelah tema selesai dibuat:

1. **Aktivasi Tema**

   - Buka `http://localhost/websiteku/wp-admin`
   - Go to Appearance > Themes
   - Aktifkan tema "Websiteku"

2. **Test Homepage**

   - Akses `http://localhost/websiteku`
   - Verifikasi tampilan sesuai branding hijau/biru
   - Cek responsive di mobile (resize browser)

3. **Test Chatbot**

   - Klik icon chatbot di pojok kanan bawah
   - Ketik pertanyaan contoh: "apa itu komputer"
   - Verifikasi bot memberikan jawaban
   - Test fallback dengan pertanyaan random

4. **Test Navigation**
   - Klik semua menu navigasi
   - Pastikan tidak ada broken links

---

## User Review Required

> [!IMPORTANT]
> Sebelum lanjut, mohon konfirmasi:
>
> 1. Apakah struktur dan fitur di atas sudah sesuai?
> 2. Untuk logo sekolah, apakah kamu punya file yang lebih jelas? (PNG/SVG transparan)
> 3. Materi TIK untuk chatbot akan diinput sendiri nanti atau mau dibuatkan contoh terlebih dahulu?
