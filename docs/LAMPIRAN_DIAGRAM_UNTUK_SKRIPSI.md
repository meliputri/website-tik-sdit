# Lampiran Diagram untuk Skripsi (BAB III & IV)

Salin blok **Mermaid** di bawah ini ke [Mermaid Live Editor](https://mermaid.live) lalu export PNG/SVG untuk Word/PDF.

Diagram lengkap juga ada di:
- `docs/diagram_skripsi_bab3_4.md`
- `docs/diagram_tambahan_skripsi.md`

---

## 1. Use Case Diagram (ringkas)

```mermaid
flowchart LR
    subgraph Actors
        S[Siswa]
        A[Admin/Guru]
    end
    subgraph Sistem
        UC1[Lihat Materi TIK]
        UC2[Tonton Video]
        UC3[Kerjakan Quiz]
        UC4[Chatbot AI]
        UC5[Kelola Materi]
        UC6[Upload Dataset RAG]
        UC7[Lihat Log Chat]
    end
    S --> UC1
    S --> UC2
    S --> UC3
    S --> UC4
    A --> UC5
    A --> UC6
    A --> UC7
    UC5 -.-> UC1
    UC6 -.-> UC4
```

---

## 2. Sequence Diagram — Chatbot + RAG + Log MySQL

```mermaid
sequenceDiagram
    participant U as Siswa
    participant W as WordPress
    participant N as n8n
    participant R as RAG Supabase
    participant D as MySQL Log

    U->>W: Kirim pertanyaan + kelas
    alt n8n aktif
        W->>N: Webhook + materiContext
        N->>R: Retrieval dokumen
        R-->>N: Konteks vektor
        N-->>W: Jawaban Gemini
        W->>D: INSERT log (source=n8n)
        W-->>U: Jawaban AI
    else fallback
        W-->>U: Jawaban rule/materi
        W->>D: INSERT log (source=rule/materi)
    end
```

---

## 3. Flowchart — Alur Siswa Belajar

```mermaid
flowchart TD
    A[Buka Website] --> B{Pilih menu}
    B -->|Beranda| C[Lihat ringkasan materi]
    B -->|/materi/| D[Filter kelas & cari materi]
    D --> E[Buka detail / Video / PDF]
    E --> F{Quiz?}
    F -->|Ya| G[Kerjakan quiz & skor]
    F -->|Tidak| H[Tanya Chatbot]
    H --> I[Jawaban tersimpan di MySQL]
    G --> J[Papan peringkat]
```

---

## 4. Arsitektur Data (Proposal BAB IV)

```mermaid
flowchart TB
    WP[WordPress MySQL]
    WP --> M[Materi / Quiz / Options]
    WP --> L[wp_websiteku_chat_logs]
    WP --> F[uploads/websiteku-rag]
    F --> N8N[n8n Workflow]
    N8N --> SB[Supabase Vector]
    N8N --> GM[Gemini LLM]
```

---

*Setelah export gambar, sisipkan ke naskah dengan caption: Gambar X.X Use Case Diagram, dll.*
