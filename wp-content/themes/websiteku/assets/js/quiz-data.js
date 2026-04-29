/**
 * Quiz System - Kuis Interaktif TIK
 * 
 * @package Websiteku
 */

const QuizData = {
    // ========== Quiz Bab 1: Pengenalan Komputer ==========
    "pengenalan-komputer": {
        title: "Pengenalan Komputer",
        description: "Uji pemahamanmu tentang dasar-dasar komputer",
        icon: "🖥️",
        questions: [
            {
                question: "Apa kepanjangan dari CPU?",
                options: [
                    "Central Processing Unit",
                    "Computer Personal Unit",
                    "Central Program Utility",
                    "Computer Processing Unit"
                ],
                correct: 0,
                explanation: "CPU adalah singkatan dari Central Processing Unit, yaitu otak dari komputer yang memproses semua instruksi."
            },
            {
                question: "Komputer pertama di dunia bernama?",
                options: [
                    "UNIVAC",
                    "ENIAC",
                    "IBM PC",
                    "Apple I"
                ],
                correct: 1,
                explanation: "ENIAC (Electronic Numerical Integrator and Computer) adalah komputer pertama yang dibuat pada tahun 1945."
            },
            {
                question: "Manakah yang BUKAN merupakan jenis komputer?",
                options: [
                    "Desktop",
                    "Laptop",
                    "Printer",
                    "Tablet"
                ],
                correct: 2,
                explanation: "Printer adalah perangkat output, bukan jenis komputer. Desktop, laptop, dan tablet adalah jenis-jenis komputer."
            },
            {
                question: "Apa fungsi utama komputer?",
                options: [
                    "Hanya untuk bermain game",
                    "Menerima input, memproses data, dan menghasilkan output",
                    "Hanya untuk mengetik dokumen",
                    "Hanya untuk browsing internet"
                ],
                correct: 1,
                explanation: "Komputer memiliki fungsi utama untuk menerima input, memproses data, menyimpan data, dan menghasilkan output."
            },
            {
                question: "Siapa yang dijuluki 'Bapak Komputer'?",
                options: [
                    "Bill Gates",
                    "Steve Jobs",
                    "Charles Babbage",
                    "Mark Zuckerberg"
                ],
                correct: 2,
                explanation: "Charles Babbage dijuluki Bapak Komputer karena merancang mesin hitung mekanis pertama yang menjadi dasar komputer modern."
            }
        ]
    },
    
    // ========== Quiz Bab 2: Hardware ==========
    "hardware": {
        title: "Perangkat Keras (Hardware)",
        description: "Uji pemahamanmu tentang komponen fisik komputer",
        icon: "⌨️",
        questions: [
            {
                question: "Manakah yang termasuk perangkat INPUT?",
                options: [
                    "Monitor",
                    "Printer",
                    "Keyboard",
                    "Speaker"
                ],
                correct: 2,
                explanation: "Keyboard adalah perangkat input untuk memasukkan data berupa teks ke komputer."
            },
            {
                question: "RAM adalah singkatan dari?",
                options: [
                    "Read Access Memory",
                    "Random Access Memory",
                    "Run Application Memory",
                    "Ready Active Memory"
                ],
                correct: 1,
                explanation: "RAM (Random Access Memory) adalah memori sementara yang menyimpan data saat komputer sedang berjalan."
            },
            {
                question: "Apa fungsi dari harddisk?",
                options: [
                    "Menampilkan gambar",
                    "Menyimpan data secara permanen",
                    "Memproses data",
                    "Mengeluarkan suara"
                ],
                correct: 1,
                explanation: "Harddisk berfungsi untuk menyimpan data secara permanen, data tetap ada walaupun komputer dimatikan."
            },
            {
                question: "Manakah yang termasuk perangkat OUTPUT?",
                options: [
                    "Mouse",
                    "Keyboard",
                    "Scanner",
                    "Monitor"
                ],
                correct: 3,
                explanation: "Monitor adalah perangkat output yang menampilkan hasil pemrosesan komputer dalam bentuk visual."
            },
            {
                question: "Apa perbedaan SSD dengan HDD?",
                options: [
                    "SSD lebih lambat dari HDD",
                    "SSD lebih cepat dan tidak bergerak (no moving parts)",
                    "HDD lebih mahal dari SSD",
                    "Tidak ada perbedaan"
                ],
                correct: 1,
                explanation: "SSD (Solid State Drive) lebih cepat dari HDD karena tidak memiliki komponen bergerak dan menggunakan chip memori."
            }
        ]
    },
    
    // ========== Quiz Bab 3: Software ==========
    "software": {
        title: "Perangkat Lunak (Software)",
        description: "Uji pemahamanmu tentang program komputer",
        icon: "💿",
        questions: [
            {
                question: "Apa itu sistem operasi?",
                options: [
                    "Aplikasi untuk mengetik",
                    "Perangkat keras komputer",
                    "Software utama yang mengelola hardware dan software lain",
                    "Kabel untuk menghubungkan komputer"
                ],
                correct: 2,
                explanation: "Sistem operasi adalah software utama yang mengelola semua hardware dan software di komputer."
            },
            {
                question: "Manakah yang merupakan sistem operasi?",
                options: [
                    "Microsoft Word",
                    "Google Chrome",
                    "Windows 11",
                    "Photoshop"
                ],
                correct: 2,
                explanation: "Windows 11 adalah sistem operasi buatan Microsoft. Word, Chrome, dan Photoshop adalah aplikasi."
            },
            {
                question: "Browser digunakan untuk?",
                options: [
                    "Mengedit foto",
                    "Mengakses internet dan website",
                    "Membuat presentasi",
                    "Menghitung angka"
                ],
                correct: 1,
                explanation: "Browser adalah aplikasi untuk mengakses internet dan membuka website seperti Google, YouTube, dll."
            },
            {
                question: "Contoh aplikasi pengolah kata adalah?",
                options: [
                    "Microsoft Excel",
                    "Microsoft PowerPoint",
                    "Microsoft Word",
                    "Microsoft Access"
                ],
                correct: 2,
                explanation: "Microsoft Word adalah aplikasi pengolah kata untuk membuat dokumen, surat, dan laporan."
            },
            {
                question: "Software yang gratis dan kode sumbernya terbuka disebut?",
                options: [
                    "Freeware",
                    "Shareware",
                    "Open Source",
                    "Commercial"
                ],
                correct: 2,
                explanation: "Open Source adalah software yang gratis dan kode programnya bisa dilihat serta dimodifikasi oleh siapa saja."
            }
        ]
    },
    
    // ========== Quiz Bab 4: Internet ==========
    "internet": {
        title: "Internet & Jaringan",
        description: "Uji pemahamanmu tentang internet dan komunikasi digital",
        icon: "🌐",
        questions: [
            {
                question: "Apa kepanjangan dari WWW?",
                options: [
                    "World Wide Website",
                    "World Wide Web",
                    "Web World Wide",
                    "Wide World Web"
                ],
                correct: 1,
                explanation: "WWW adalah singkatan dari World Wide Web, yaitu sistem informasi di internet yang menggunakan hyperlink."
            },
            {
                question: "Apa fungsi dari email?",
                options: [
                    "Bermain game online",
                    "Mengirim surat elektronik",
                    "Mengedit video",
                    "Mencetak dokumen"
                ],
                correct: 1,
                explanation: "Email (Electronic Mail) berfungsi untuk mengirim dan menerima surat elektronik melalui internet."
            },
            {
                question: "WiFi adalah teknologi untuk?",
                options: [
                    "Mencetak dokumen",
                    "Koneksi internet tanpa kabel",
                    "Menyimpan data",
                    "Menampilkan gambar"
                ],
                correct: 1,
                explanation: "WiFi adalah teknologi jaringan nirkabel (wireless) untuk menghubungkan perangkat ke internet tanpa kabel."
            },
            {
                question: "Apa itu URL?",
                options: [
                    "Nama pengguna internet",
                    "Alamat website di internet",
                    "Jenis browser",
                    "Kecepatan internet"
                ],
                correct: 1,
                explanation: "URL (Uniform Resource Locator) adalah alamat unik untuk mengakses halaman web di internet."
            },
            {
                question: "Manakah yang merupakan mesin pencari (search engine)?",
                options: [
                    "Facebook",
                    "WhatsApp",
                    "Google",
                    "Instagram"
                ],
                correct: 2,
                explanation: "Google adalah mesin pencari (search engine) yang digunakan untuk mencari informasi di internet."
            }
        ]
    }
};

// Export for use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = QuizData;
}
