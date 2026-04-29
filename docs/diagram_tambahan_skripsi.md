# Wireframe & Flowchart Tambahan
## BAB IV: Hasil dan Pembahasan

---

## 1. Wireframe Antarmuka Mobile (Smartphone)
Karena website bersifat responsif, berikut adalah rancangan antarmuka saat diakses melalui perangkat *smartphone*.

![Wireframe Mobile](C:\Users\LENOVO\.gemini\antigravity\brain\65b15c48-7f7b-454c-8c07-f42a4ea3a443\wireframe_mobile_1777462765579.png)

**Keterangan:**
- Navbar berubah menjadi Hamburger Menu (tombol garis tiga).
- Elemen konten yang sebelumnya menyamping (kolom) berubah menjadi bersusun ke bawah (vertikal) agar mudah di-*scroll*.
- Tombol Chatbot tetap *floating* di pojok kanan bawah agar mudah dijangkau ibu jari.

---

## 2. Wireframe Halaman Admin (WordPress)
Berikut adalah rancangan antarmuka *backend* bagi guru/admin untuk mengelola materi dan quiz.

![Wireframe Admin WP](C:\Users\LENOVO\.gemini\antigravity\brain\65b15c48-7f7b-454c-8c07-f42a4ea3a443\wireframe_admin_1777462786911.png)

**Keterangan:**
- **Panel Kiri (Tabel Data):** Menampilkan daftar materi TIK yang sudah dibuat beserta kolom Bab, Ikon, Status Aktif, dan Relasi Quiz.
- **Panel Kanan (Form Input):** Form *Custom Post Type* yang dilengkapi *Meta Box* di sebelah kanan untuk memilih Bab, mengganti ikon, mengatur status materi, dan menautkan kuis terkait.

---

## 3. Flowchart Alur Sistem Chatbot AI (n8n + RAG)
Berikut adalah *Flowchart* yang menggambarkan alur kerja sistem dari saat pengguna mengetik pesan hingga AI membalas. (Diagram ini sangat cocok untuk BAB IV bagian Arsitektur/Flow System).

```mermaid
flowchart TD
    A([Mulai]) --> B[/User Membuka Chatbot/]
    B --> C[/User Mengetik & Mengirim Pertanyaan TIK/]
    C --> D{Koneksi Internet & Server Aktif?}
    
    D -- Tidak --> E[Sistem Fallback Rule-Based Lokal]
    E --> F[Pencarian Keyword di Script JavaScript]
    F --> G[/Tampilkan Balasan Hardcoded/]
    
    D -- Ya --> H[Frontend Mengirim HTTP POST request ke Webhook n8n]
    H --> I[Webhook n8n Menerima Payload Pesan]
    
    I --> J[Agent AI Memulai Proses]
    J --> K[RAG: Mengambil Konteks Relevan dari Supabase Vector DB]
    
    K --> L{Konteks Ditemukan?}
    L -- Ya --> M[Konteks digabungkan ke System Prompt]
    L -- Tidak --> N[Hanya gunakan System Prompt Dasar]
    
    M --> O[Kirim Prompt + Pesan + Konteks ke Google Gemini]
    N --> O
    
    O --> P[Google Gemini Menghasilkan Respons / Jawaban]
    P --> Q[n8n Mengirim Respons kembali via Webhook]
    
    Q --> R[Frontend Menerima & Menampilkan Jawaban di Chat Bubble]
    R --> S([Selesai])
    G --> S
```

### Penjelasan Flowchart:
1. **User Input:** Siswa membuka chatbot dan mengirimkan pertanyaan.
2. **Pengecekan Fallback:** Jika server n8n mati, sistem menggunakan fallback script lokal yang berbasis deteksi *keyword*.
3. **Webhook n8n:** Jika server aktif, pesan dikirim ke `Webhook URL` n8n.
4. **Proses RAG:** Sistem mengambil data yang relevan dari Vector Database (Supabase) berdasarkan pertanyaan siswa.
5. **Proses AI:** Data konteks dan pertanyaan diberikan kepada Google Gemini.
6. **Respons:** AI memproses jawaban dan mengembalikannya ke layar *chat* siswa.
