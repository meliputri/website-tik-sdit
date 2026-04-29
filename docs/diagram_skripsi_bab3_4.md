# 📊 Diagram Tambahan untuk Skripsi (Bab III / Bab IV)

File ini berisi **Use Case Diagram** dan **Flowchart Sistem Umum** yang sangat dibutuhkan untuk laporan skripsi (Biasanya ditaruh di Bab III Perancangan Sistem atau Bab IV Implementasi).

Kamu bisa *copy-paste* kode di bawah ini ke editor Mermaid online (seperti [Mermaid Live Editor](https://mermaid.live/)) untuk men-download gambarnya, atau biarkan di sini karena GitHub bisa langsung menampilkannya menjadi gambar.

---

## 1. Use Case Diagram
Diagram ini menjelaskan interaksi antara pengguna (Guru/Admin dan Siswa) dengan fitur-fitur di dalam website.

```mermaid
graph LR
    Admin(Guru Admin)
    Siswa(Siswa SD)

    subgraph Sistem Pembelajaran TIK Berbasis AI
        UC1(Login Admin)
        UC2(Mengelola Modul Materi)
        UC3(Mengelola Soal Kuis)
        UC4(Membaca Materi Pelajaran)
        UC5(Mengerjakan Kuis Interaktif)
        UC6(Bertanya pada Chatbot AI)
        UC7(Melihat Hasil Kuis)
    end

    Admin --- UC1
    Admin --- UC2
    Admin --- UC3

    Siswa --- UC4
    Siswa --- UC5
    Siswa --- UC6
    Siswa --- UC7
```

*Penjelasan Use Case untuk narasi Bab IV:*
- **Guru/Admin:** Memiliki hak akses penuh untuk masuk ke Dashboard WordPress (Login), menambahkan/mengubah materi pelajaran TIK, dan mengatur pertanyaan kuis.
- **Siswa:** Berperan sebagai pengguna akhir yang dapat membaca materi, mengerjakan kuis untuk menguji pemahaman, melihat nilai secara langsung, dan bertanya pada Chatbot AI jika ada materi yang kurang dipahami.

---

## 2. Diagram Alur Chatbot Lintas Fungsi (Swimlane / Sequence)
Untuk menggambarkan alur seperti pada gambar keduamu (yang dibagi menjadi kolom User, Chatbot, RAG, dan Database), dalam dunia *UML* biasanya digunakan **Sequence Diagram** atau **Activity Diagram dengan Swimlane**.

Berikut adalah representasinya dalam bentuk **Sequence Diagram** (Sangat disarankan untuk skripsi karena lebih profesional):

```mermaid
sequenceDiagram
    participant U as User
    participant C as Chatbot
    participant R as RAG n8n
    participant D as Database Supabase
    
    U->>C: Mengirim Pertanyaan TIK
    C->>R: Meneruskan Pertanyaan Webhook
    R->>D: Mencari Kemiripan Materi Vector
    
    alt Materi Ditemukan
        D-->>R: Mengembalikan Konteks Materi
        R->>R: Menggabungkan Konteks & Pertanyaan
    else Materi Tidak Ada
        D-->>R: Hasil Kosong
        R->>R: Gunakan Prompt Biasa
    end
    
    R->>C: Mengirimkan Jawaban AI
    C-->>U: Menampilkan Jawaban ke Layar
```

*(Catatan: Jika kamu **wajib** menggunakan diagram kotak-kotak bertabel / Swimlane Activity persis seperti gambarmu, kamu harus menggambarnya secara manual menggunakan aplikasi seperti **Microsoft Visio** atau situs web gratis **[Draw.io](https://app.diagrams.net/)** karena Mermaid tidak memiliki format tabel untuk Flowchart).*

---

## 3. Flowchart Sistem Umum (User Flow)
Berbeda dengan *Flowchart* RAG (yang khusus membahas cara kerja AI), *Flowchart* ini menggambarkan alur perjalanan siswa saat menggunakan website dari awal sampai akhir.

```mermaid
graph TD
    Start(Mulai Akses Website) --> Menu{Pilih Menu}
    
    Menu --> Materi(Pilih dan Baca Materi TIK)
    Materi --> Tanya{Ada Pertanyaan}
    
    Tanya -- Ya --> BukaAI(Buka Widget Chatbot)
    BukaAI --> KirimTanya(Kirim Pertanyaan)
    KirimTanya --> TerimaJawab(Terima Jawaban dari AI)
    
    Tanya -- Tidak --> SelesaiMateri(Selesai Membaca)
    
    Menu --> Kuis(Kerjakan Soal Pilihan Ganda)
    Kuis --> Hitung(Sistem Menghitung Jawaban)
    Hitung --> Hasil(Tampilkan Skor Nilai Akhir)
    
    Menu --> Kontak(Lihat Informasi Pengembang)
    
    TerimaJawab --> End(Selesai)
    SelesaiMateri --> End
    Hasil --> End
    Kontak --> End
```

*Penjelasan Flowchart untuk narasi Bab IV:*
1. Siswa memulai dengan membuka halaman utama website.
2. Siswa dihadapkan pada pilihan menu: Materi, Kuis, atau Kontak.
3. Jika memilih **Materi**, siswa membaca modul. Apabila ada kebingungan, siswa dapat membuka *widget* Chatbot untuk berinteraksi dengan AI.
4. Jika memilih **Kuis**, siswa menjawab serangkaian soal dan sistem akan otomatis memberikan skor akhir.
5. Selesai.
