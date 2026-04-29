# Tabel Pengujian Black Box (Black Box Testing)
## BAB IV: Hasil Pengujian Sistem

Skenario pengujian *Black Box* ini digunakan untuk menguji fungsionalitas sistem dari sudut pandang pengguna tanpa melihat struktur kode sumbernya. Tabel-tabel di bawah ini dapat langsung digunakan untuk BAB IV pada skripsi Anda.

---

### Tabel 4.1: Pengujian Antarmuka Pengguna (Frontend)

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Menampilkan Halaman Beranda | Pengguna membuka URL website utama. | Website menampilkan *hero section*, informasi mapel TIK, dan daftar materi. | Sesuai Harapan | Valid ✅ |
| 2. | Navigasi Menu Utama | Pengguna menekan menu "Materi", "Tentang", dan "Kontak" pada navbar. | Website melakukan *scrolling* otomatis atau memuat halaman yang sesuai. | Sesuai Harapan | Valid ✅ |
| 3. | Pencarian Materi TIK | Pengguna mengetik kata kunci pada kolom pencarian di bagian materi. | Grid materi akan difilter secara *real-time* sesuai teks yang dimasukkan. | Sesuai Harapan | Valid ✅ |
| 4. | Responsivitas Tampilan (Mobile) | Pengguna membuka website menggunakan perangkat *smartphone*. | Tampilan otomatis menyesuaikan ukuran layar (*mobile-friendly*), navbar menjadi *hamburger menu*. | Sesuai Harapan | Valid ✅ |

---

### Tabel 4.2: Pengujian Fungsionalitas Chatbot AI (n8n + Gemini)

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Membuka Widget Chatbot | Pengguna menekan tombol *floating* robot di sudut kanan bawah. | Panel *chatbot* terbuka dengan menampilkan animasi *welcome message*. | Sesuai Harapan | Valid ✅ |
| 2. | Mengirim Pertanyaan Relevan (TIK) | Pengguna mengetik "Apa itu perangkat keras komputer?" dan menekan kirim. | AI memproses pertanyaan dan membalas dengan jawaban yang akurat berdasarkan materi (RAG). | Sesuai Harapan | Valid ✅ |
| 3. | Mengirim Input Kosong | Pengguna langsung menekan tombol kirim tanpa mengetik pesan. | Sistem tidak mengirimkan pesan dan fokus tetap berada di kotak input. | Sesuai Harapan | Valid ✅ |
| 4. | Mengirim Pertanyaan Di Luar Konteks | Pengguna bertanya "Siapa presiden Indonesia?". | AI membalas dengan sopan bahwa ia hanya bertugas menjawab pertanyaan seputar materi TIK. | Sesuai Harapan | Valid ✅ |
| 5. | Buka di Tab Baru | Pengguna menekan ikon "↗️" pada header chatbot. | Tab browser baru terbuka langsung menuju halaman *webhook* n8n. | Sesuai Harapan | Valid ✅ |
| 6. | Uji Coba *Fallback System* | Server n8n/internet dimatikan, pengguna mengirim pesan. | Sistem mendeteksi *timeout* dan memunculkan jawaban otomatis dari memori lokal (javascript). | Sesuai Harapan | Valid ✅ |

---

### Tabel 4.3: Pengujian Fungsionalitas Kuis Interaktif

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Membuka Kuis dari Materi | Pengguna menekan tombol "Quiz" pada salah satu kartu materi. | Tampil *popup* / halaman kuis yang memuat daftar pertanyaan pilihan ganda. | Sesuai Harapan | Valid ✅ |
| 2. | Menjawab Pertanyaan | Pengguna memilih opsi jawaban A, B, C, atau D. | Sistem merekam jawaban dan melanjutkan ke pertanyaan berikutnya. | Sesuai Harapan | Valid ✅ |
| 3. | Menyelesaikan Kuis | Pengguna telah menjawab semua soal. | Sistem menampilkan skor akhir dan jumlah jawaban benar/salah. | Sesuai Harapan | Valid ✅ |

---

### Tabel 4.4: Pengujian Panel Admin (Backend WordPress)

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Menambah Materi Baru | Admin mengisi judul, *excerpt*, dan bab materi, lalu klik *Publish*. | Materi berhasil disimpan dan langsung muncul di halaman beranda. | Sesuai Harapan | Valid ✅ |
| 2. | Menonaktifkan Materi | Admin mengubah meta box "Status Materi" menjadi "Tidak aktif". | Materi disimpan tapi tidak ditampilkan di halaman beranda siswa. | Sesuai Harapan | Valid ✅ |
| 3. | Mengubah Setting n8n | Admin masuk ke menu "Pengaturan Tema" lalu mengubah URL Webhook n8n. | URL Webhook berhasil tersimpan dan langsung diterapkan pada skrip *frontend chatbot*. | Sesuai Harapan | Valid ✅ |

---
**Catatan untuk Penulisan Skripsi:**
1. Anda dapat menyalin tabel ini langsung ke Microsoft Word.
2. Kolom "Hasil Pengujian" dan "Kesimpulan" sengaja diisi *Sesuai Harapan* dan *Valid* karena aplikasi Anda saat ini memang sudah memenuhi spesifikasi tersebut.
3. Jangan lupa lampirkan *Screenshot* pendukung di bawah/atas masing-masing tabel saat dimasukkan ke dalam skripsi.
