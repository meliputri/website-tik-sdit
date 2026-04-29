# Panduan Upload Website (Laragon) ke Hostinger
*Cara paling mudah dan anti-gagal, cocok untuk pemula yang tidak mau pusing coding/database.*

Daripada upload file *zip* dan *database* satu-satu secara manual (yang sering error), kita akan menggunakan bantuan Plugin gratis bernama **All-in-One WP Migration**. Ikuti langkah-langkah santai di bawah ini ya!

---

## TAHAP 1: Export dari Komputer Lokal (Laragon)

Pertama, kita harus membungkus website yang ada di laptopmu menjadi satu file.

1. Buka dan login ke WP-Admin Laragon kamu (`http://websiteku.test/wp-admin`).
2. Di menu sebelah kiri, cari menu **Plugins** > klik **Add New** (Tambah Baru).
3. Di kolom pencarian kanan atas, ketik: `All-in-One WP Migration`.
4. Klik **Install Now**, tunggu sebentar, lalu klik **Activate**.
5. Setelah aktif, akan muncul menu baru bernama **All-in-One WP Migration** di panel kiri. Klik menu tersebut, lalu pilih **Export**.
6. Klik tulisan hijau **EXPORT TO** > pilih **FILE**.
7. Tunggu proses loading selesai (biasanya animasi kotak-kotak). Kalau sudah 100%, klik tombol **DOWNLOAD** yang berkedip-kedip hijau.
8. Sebuah file dengan akhiran `.wpress` akan ter-download ke laptopmu. *(Simpan file ini baik-baik, ini adalah nyawa websitemu!)*

---

## TAHAP 2: Setup di Hostinger

Sekarang kita siapkan "rumah baru" di Hostinger.

1. Login ke akun [hPanel Hostinger](https://hpanel.hostinger.com/).
2. Pastikan domain sudah aktif. Cari menu **Website** > pilih domain kamu > klik **Kelola** (Manage).
3. Cari menu **Auto Installer** (Penginstal Otomatis) di panel sebelah kiri.
4. Pilih ikon **WordPress**.
5. Isi form instalasi (Judul website, Username Admin, dan Password). **Bebas isi apa saja** karena nanti akan tertimpa dengan data dari laptopmu.
6. Klik **Install** dan tunggu beberapa menit sampai WordPress berhasil terpasang di domainmu.

---

## TAHAP 3: Import ke Website Online (Hostinger)

Langkah terakhir! Kita masukkan file yang dari laptop tadi ke website online.

1. Buka website onlinemu dan login ke WP-Admin (contoh: `namadomain.com/wp-admin`).
2. Masukkan Username dan Password yang baru saja kamu buat di Tahap 2.
3. Sama seperti di Tahap 1, pergi ke **Plugins** > **Add New** > cari `All-in-One WP Migration` > **Install** & **Activate**.
4. Di panel kiri, klik **All-in-One WP Migration** > pilih **Import**.
5. Klik **IMPORT FROM** > pilih **FILE**.
6. Cari dan pilih file `.wpress` yang kamu download dari laptop tadi.
7. Tunggu proses loading sampai 100%. 
   > [!WARNING]
   > Jangan tutup tab browser selama proses ini berjalan!
8. Jika muncul peringatan *"The import process will overwrite your website..."*, klik saja tombol **PROCEED** (Lanjutkan).
9. Selesai! Klik **FINISH**.

---

## TAHAP 4: Langkah Penting Terakhir (Wajib!)

Setelah import selesai, website akan me-logout kamu otomatis karena akun adminnya sudah kembali menggunakan akun yang lama (sama seperti di Laragon).

1. Login kembali ke `namadomain.com/wp-admin` menggunakan **Username dan Password Laragon** kamu.
2. Di menu kiri, buka **Settings** (Pengaturan) > **Permalinks**.
3. *Scroll* ke bawah dan langsung klik tombol biru **Save Changes** (Simpan Perubahan). **Lakukan klik Save Changes ini sebanyak 2 KALI**. (Ini trik wajib agar halaman tidak *error 404/Not Found*).

🎉 **Selamat! Website sudah 100% online di Hostinger!** Coba buka domainmu di tab baru, tampilannya akan persis sama seperti di Laragon.

---
### Catatan Tambahan untuk n8n:
Karena websitemu sekarang sudah *online*, kamu **tidak perlu ubah apa-apa** di settingan n8n asalkan Webhook URL n8n kamu memang sudah menggunakan server yang aktif/online. Chatbot akan langsung berfungsi!
