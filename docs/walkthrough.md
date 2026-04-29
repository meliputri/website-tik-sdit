# ✅ Walkthrough: Tema "Websiteku" + Fitur Baru

## 📁 Struktur Tema

```
wp-content/themes/websiteku/
├── index.php         # Homepage dengan quiz & PDF
├── style.css         # Styles utama
├── functions.php     # Enqueue scripts
├── header.php / footer.php
├── assets/
│   ├── css/
│   │   ├── chatbot.css
│   │   └── quiz.css
│   ├── js/
│   │   ├── chatbot.js      # + Suggested questions
│   │   ├── chatbot-data.js
│   │   ├── quiz.js
│   │   └── quiz-data.js    # 4 topics, 20 soal
│   ├── images/logo.png
│   └── pdf/               # Letakkan file PDF disini
```

---

## ✨ Fitur yang Ditambahkan

### 1. 📝 Quiz Interaktif

- **4 topik**: Pengenalan Komputer, Hardware, Software, Internet
- **20 soal** dengan penjelasan setiap jawaban
- Scoring dengan feedback: 🏆 / 👍 / 📚 / 💪

**Cara pakai:** Klik tombol "Quiz" di setiap kartu materi

**Edit soal:** `assets/js/quiz-data.js`

---

### 2. 💬 Chatbot Suggested Questions

- Tombol pertanyaan populer di awal chat
- Klik untuk langsung bertanya
- Tombol "Lihat lainnya" untuk lebih banyak opsi

---

### 3. 📥 Download PDF

Folder: `assets/pdf/`

File yang perlu ditambahkan:

- `bab1-pengenalan-komputer.pdf`
- `bab2-hardware.pdf`
- `bab3-software.pdf`
- `bab4-internet.pdf`
- `bab5-keamanan-digital.pdf`
- `bab6-aplikasi-produktivitas.pdf`

---

## 🚀 Aktivasi

1. Buka `http://websiteku.test/wp-admin`
2. **Appearance > Themes > Websiteku > Activate**
3. Akses website: `http://websiteku.test`
