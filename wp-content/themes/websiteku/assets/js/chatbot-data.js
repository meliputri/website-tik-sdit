/**
 * Chatbot Data - Database Q&A untuk TIK
 * 
 * Format: keyword -> jawaban
 * Kamu bisa menambahkan/mengubah data ini sesuai materi TIK
 * 
 * @package Websiteku
 */

const ChatbotData = {
    // ========== Pengenalan Komputer ==========
    "apa itu komputer": {
        answer: "Komputer adalah perangkat elektronik yang dapat menerima input, memproses data, menyimpan data, dan menghasilkan output. Komputer terdiri dari perangkat keras (hardware) dan perangkat lunak (software).",
        keywords: ["komputer", "pengertian komputer", "definisi komputer"]
    },
    
    "sejarah komputer": {
        answer: "Komputer pertama bernama ENIAC (Electronic Numerical Integrator and Computer), dibuat pada tahun 1945 di Amerika Serikat. Ukurannya sangat besar, seisi ruangan! Sejak itu, komputer terus berkembang menjadi lebih kecil dan canggih.",
        keywords: ["sejarah", "eniac", "komputer pertama", "awal komputer"]
    },
    
    "jenis komputer": {
        answer: "Ada beberapa jenis komputer:\n1. 🖥️ Desktop - Komputer meja\n2. 💻 Laptop - Komputer jinjing\n3. 📱 Tablet - Komputer layar sentuh\n4. 🖲️ Server - Komputer pelayan jaringan\n5. 🎮 Supercomputer - Komputer super cepat untuk riset",
        keywords: ["jenis", "macam", "tipe komputer"]
    },
    
    // ========== Hardware ==========
    "apa itu hardware": {
        answer: "Hardware (perangkat keras) adalah bagian komputer yang bisa dilihat dan disentuh secara fisik. Contohnya: monitor, keyboard, mouse, CPU, RAM, dan harddisk.",
        keywords: ["hardware", "perangkat keras", "fisik komputer"]
    },
    
    "apa itu cpu": {
        answer: "CPU (Central Processing Unit) adalah 'otak' komputer yang bertugas memproses semua instruksi dan perhitungan. CPU juga disebut prosesor. Contoh merek CPU: Intel dan AMD.",
        keywords: ["cpu", "prosesor", "central processing unit", "otak komputer"]
    },
    
    "apa itu ram": {
        answer: "RAM (Random Access Memory) adalah memori sementara komputer untuk menyimpan data yang sedang diproses. Semakin besar RAM, semakin banyak program yang bisa dijalankan bersamaan. RAM akan kosong saat komputer dimatikan.",
        keywords: ["ram", "memory", "memori"]
    },
    
    "apa itu harddisk": {
        answer: "Harddisk (HDD) adalah tempat penyimpanan data permanen di komputer. Berbeda dengan RAM, data di harddisk tetap tersimpan walaupun komputer dimatikan. Ada juga SSD yang lebih cepat dari HDD.",
        keywords: ["harddisk", "hdd", "ssd", "penyimpanan", "storage"]
    },
    
    "apa itu monitor": {
        answer: "Monitor adalah perangkat output yang menampilkan gambar dan teks dari komputer. Monitor modern menggunakan teknologi LCD atau LED. Ukuran monitor diukur secara diagonal dalam satuan inci.",
        keywords: ["monitor", "layar", "display", "screen"]
    },
    
    "apa itu keyboard": {
        answer: "Keyboard adalah perangkat input untuk mengetik huruf, angka, dan simbol ke komputer. Keyboard QWERTY adalah layout yang paling umum digunakan. Ada juga keyboard gaming dengan fitur tambahan.",
        keywords: ["keyboard", "papan ketik", "mengetik"]
    },
    
    "apa itu mouse": {
        answer: "Mouse adalah perangkat input untuk menggerakkan kursor di layar. Mouse memiliki tombol kiri (klik), tombol kanan (menu), dan scroll wheel. Ada mouse kabel dan wireless (tanpa kabel).",
        keywords: ["mouse", "tetikus", "kursor"]
    },
    
    // ========== Software ==========
    "apa itu software": {
        answer: "Software (perangkat lunak) adalah program atau aplikasi yang menjalankan komputer. Software tidak bisa disentuh karena berupa kode program. Contoh: Windows, Microsoft Word, Chrome.",
        keywords: ["software", "perangkat lunak", "program", "aplikasi"]
    },
    
    "apa itu sistem operasi": {
        answer: "Sistem Operasi (OS) adalah software utama yang mengelola semua hardware dan software di komputer. Contoh sistem operasi:\n- Windows (Microsoft)\n- macOS (Apple)\n- Linux (Open Source)\n- Android (untuk HP)",
        keywords: ["sistem operasi", "os", "operating system", "windows", "linux", "macos"]
    },
    
    "apa itu browser": {
        answer: "Browser adalah aplikasi untuk mengakses internet dan membuka website. Contoh browser populer:\n🌐 Google Chrome\n🦊 Mozilla Firefox\n🔵 Microsoft Edge\n🧭 Safari",
        keywords: ["browser", "peramban", "chrome", "firefox", "edge"]
    },
    
    // ========== Internet ==========
    "apa itu internet": {
        answer: "Internet adalah jaringan komputer global yang menghubungkan jutaan komputer di seluruh dunia. Dengan internet, kita bisa mengakses informasi, berkomunikasi, belajar, dan bermain game online.",
        keywords: ["internet", "jaringan", "online", "world wide web"]
    },
    
    "apa itu website": {
        answer: "Website adalah kumpulan halaman web yang bisa diakses melalui internet menggunakan browser. Setiap website memiliki alamat unik yang disebut URL (contoh: www.google.com).",
        keywords: ["website", "web", "situs", "halaman web"]
    },
    
    "apa itu email": {
        answer: "Email (Electronic Mail) adalah surat elektronik untuk berkomunikasi melalui internet. Untuk membuat email, kamu bisa menggunakan layanan seperti Gmail, Yahoo Mail, atau Outlook.",
        keywords: ["email", "surat elektronik", "gmail", "electronic mail"]
    },
    
    "apa itu wifi": {
        answer: "WiFi adalah teknologi jaringan nirkabel (tanpa kabel) untuk menghubungkan perangkat ke internet. WiFi memancarkan sinyal radio yang bisa ditangkap oleh laptop, HP, atau tablet.",
        keywords: ["wifi", "wireless", "nirkabel", "hotspot"]
    },
    
    // ========== Keamanan Digital ==========
    "apa itu password": {
        answer: "Password adalah kata sandi rahasia untuk melindungi akun dan data kita. Tips password yang kuat:\n🔐 Minimal 8 karakter\n🔐 Campuran huruf besar, kecil, angka\n🔐 Jangan pakai nama atau tanggal lahir\n🔐 Berbeda untuk setiap akun",
        keywords: ["password", "kata sandi", "sandi", "kunci"]
    },
    
    "apa itu virus komputer": {
        answer: "Virus komputer adalah program jahat yang bisa merusak data dan sistem. Untuk mencegah virus:\n🛡️ Install antivirus\n🛡️ Jangan download dari situs tidak jelas\n🛡️ Jangan klik link mencurigakan\n🛡️ Update software secara rutin",
        keywords: ["virus", "malware", "antivirus", "keamanan"]
    },
    
    "apa itu phishing": {
        answer: "Phishing adalah penipuan online untuk mencuri data pribadi (password, nomor kartu, dll) dengan menyamar sebagai pihak terpercaya. Hati-hati dengan email atau pesan yang meminta data pribadi!",
        keywords: ["phishing", "penipuan", "scam", "tipu"]
    },
    
    // ========== Aplikasi Produktivitas ==========
    "apa itu microsoft word": {
        answer: "Microsoft Word adalah aplikasi pengolah kata untuk membuat dokumen seperti surat, laporan, dan tugas sekolah. Fitur utamanya: mengetik, format teks, menyisipkan gambar, dan mencetak dokumen.",
        keywords: ["word", "microsoft word", "pengolah kata", "dokumen"]
    },
    
    "apa itu microsoft excel": {
        answer: "Microsoft Excel adalah aplikasi spreadsheet untuk mengolah data dalam bentuk tabel. Excel bisa digunakan untuk:\n📊 Membuat tabel data\n📊 Perhitungan otomatis\n📊 Membuat grafik\n📊 Analisis data",
        keywords: ["excel", "microsoft excel", "spreadsheet", "tabel"]
    },
    
    "apa itu microsoft powerpoint": {
        answer: "Microsoft PowerPoint adalah aplikasi untuk membuat presentasi digital dengan slide. Fiturnya: menambahkan teks, gambar, video, animasi, dan transisi antar slide.",
        keywords: ["powerpoint", "presentasi", "slide", "ppt"]
    },
    
    // ========== Default Response ==========
    "default": {
        answer: "Maaf, saya belum memahami pertanyaan kamu. Coba tanyakan tentang:\n• Apa itu komputer\n• Hardware & Software\n• Internet & Browser\n• Keamanan digital\n• Microsoft Office\n\nAtau ketik pertanyaan dengan kata kunci yang lebih spesifik! 😊",
        keywords: []
    }
};

// Export for use in chatbot.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChatbotData;
}
