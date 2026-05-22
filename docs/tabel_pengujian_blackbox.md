# Tabel Pengujian Black Box (Black Box Testing)
## BAB IV: Hasil Pengujian Sistem

Skenario pengujian dari sudut pandang pengguna. Kolom **Hasil Pengujian** diisi setelah uji manual; gunakan **Pengaturan Tema → Status Pengujian** untuk cek otomatis sebagian item.

**Cara uji cepat:** Impor materi contoh → buka `/materi/` → kirim 2–3 pesan chatbot → upload 1 PDF di Dataset RAG → screenshot tiap langkah.

---

### Tabel 4.1: Pengujian Antarmuka Pengguna (Frontend)

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Menampilkan Halaman Beranda | Buka URL utama. | Hero, info mapel, daftar materi, filter kelas. | *(isi setelah uji)* | |
| 2. | Halaman Materi `/materi/` | Buka menu Materi atau `/materi/`. | Halaman arsip materi per kelas dengan TP dan video. | *(isi setelah uji)* | |
| 3. | Navigasi Menu | Klik Beranda, Materi, Tentang, Kontak. | Halaman/scroll sesuai menu. | *(isi setelah uji)* | |
| 4. | Pencarian & Filter Kelas | Ketik kata kunci; pilih Kelas 4. | Grid terfilter real-time. | *(isi setelah uji)* | |
| 5. | Video Animasi | Klik tombol Video pada kartu materi. | Modal pemutar YouTube/Vimeo terbuka. | *(isi setelah uji)* | |
| 6. | Responsivitas Mobile | Buka di smartphone. | Layout menyesuaikan; menu hamburger. | *(isi setelah uji)* | |

---

### Tabel 4.2: Pengujian Fungsionalitas Chatbot AI

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Membuka Widget Chatbot | Klik tombol floating chat. | Panel terbuka + pesan sambutan. | *(isi setelah uji)* | |
| 2. | Pertanyaan TIK (RAG) | Tanya "Apa itu perangkat keras?" | Jawaban relevan materi (n8n aktif). | *(isi setelah uji)* | |
| 3. | Input Kosong | Kirim tanpa teks. | Pesan peringatan; tidak mengirim ke server. | *(isi setelah uji)* | |
| 4. | Pilih Kelas di Chatbot | Pilih Kelas 3, tanya TP/materi. | Jawaban sesuai kelas 3. | *(isi setelah uji)* | |
| 5. | Fallback rule-based | Matikan n8n / timeout. | Jawaban dari database lokal. | *(isi setelah uji)* | |
| 6. | **Log ke MySQL** | Setelah chat, buka admin Log Percakapan. | Baris baru di tabel log. | *(isi setelah uji)* | |

---

### Tabel 4.3: Pengujian Kuis Interaktif

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Membuka Kuis | Klik Quiz pada materi. | Modal kuis terbuka. | *(isi setelah uji)* | |
| 2. | Menjawab Soal | Pilih opsi A–D. | Lanjut ke soal berikutnya. | *(isi setelah uji)* | |
| 3. | Menyelesaikan Kuis | Jawab semua soal. | Skor + opsi sertifikat. | *(isi setelah uji)* | |

---

### Tabel 4.4: Pengujian Panel Admin (Backend)

| No | Skenario Pengujian | Skenario / Input | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|:---|:---|:---|:---|:---|:---|
| 1. | Impor Materi Contoh | Materi TIK → Impor Materi Contoh. | ≥8 materi published dengan TP & video. | *(isi setelah uji)* | |
| 2. | Upload Dataset RAG | Pengaturan Tema → Dataset RAG → upload PDF. | File tersimpan & terdaftar. | *(isi setelah uji)* | |
| 3. | Lihat Log Chatbot | Chatbot Q&A → Log Percakapan. | Daftar pertanyaan–jawaban + export CSV. | *(isi setelah uji)* | |
| 4. | Setting n8n | Ubah webhook URL, simpan. | Chatbot memakai URL baru. | *(isi setelah uji)* | |
| 5. | Status Pengujian | Pengaturan Tema → Status Pengujian. | Checklist sistem (materi, log, RAG, REST). | *(isi setelah uji)* | |

---

### Tabel 4.5: Penyimpanan Data (Sesuai Proposal BAB IV)

| Data | Penyimpanan | Status |
|:---|:---|:---|
| Materi, quiz, pengaturan | MySQL WordPress (`wp_posts`, `wp_postmeta`, `wp_options`) | ✅ |
| **Interaksi chatbot** | MySQL `wp_websiteku_chat_logs` | ✅ |
| Embedding RAG | Supabase (via n8n) | ✅ (eksternal) |
| Dataset dokumen | `wp-content/uploads/websiteku-rag/` + opsi `websiteku_rag_files` | ✅ |

---

**Lampiran skripsi:** Salin diagram dari `docs/diagram_skripsi_bab3_4.md` dan `docs/diagram_tambahan_skripsi.md` ke Word/PDF.  
**Screenshot wajib:** Beranda, `/materi/`, detail materi + video, chatbot, log MySQL, upload RAG, status pengujian.
