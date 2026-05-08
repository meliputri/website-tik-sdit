/**
 * Certificate Generation Logic
 */

function generateCertificate(studentName, quizTitle, schoolName) {
    // Buat canvas
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    
    // Set ukuran A4 landscape (297mm x 210mm) -> pada 96 DPI sekitar 1123 x 794 pixel
    canvas.width = 1123;
    canvas.height = 794;
    
    // Background
    ctx.fillStyle = '#f8f9fa';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Border luar
    ctx.strokeStyle = '#2E7D32';
    ctx.lineWidth = 15;
    ctx.strokeRect(20, 20, canvas.width - 40, canvas.height - 40);
    
    // Border dalam
    ctx.strokeStyle = '#FF9800';
    ctx.lineWidth = 5;
    ctx.strokeRect(40, 40, canvas.width - 80, canvas.height - 80);
    
    // Tambahkan elemen desain sudut
    ctx.fillStyle = '#2E7D32';
    ctx.beginPath();
    ctx.moveTo(20, 20);
    ctx.lineTo(150, 20);
    ctx.lineTo(20, 150);
    ctx.fill();
    
    ctx.beginPath();
    ctx.moveTo(canvas.width - 20, 20);
    ctx.lineTo(canvas.width - 150, 20);
    ctx.lineTo(canvas.width - 20, 150);
    ctx.fill();
    
    ctx.beginPath();
    ctx.moveTo(20, canvas.height - 20);
    ctx.lineTo(150, canvas.height - 20);
    ctx.lineTo(20, canvas.height - 150);
    ctx.fill();
    
    ctx.beginPath();
    ctx.moveTo(canvas.width - 20, canvas.height - 20);
    ctx.lineTo(canvas.width - 150, canvas.height - 20);
    ctx.lineTo(canvas.width - 20, canvas.height - 150);
    ctx.fill();
    
    // Teks Header (Nama Sekolah)
    ctx.fillStyle = '#333';
    ctx.font = 'bold 30px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(schoolName.toUpperCase(), canvas.width / 2, 120);
    
    // Garis Bawah Header
    ctx.beginPath();
    ctx.moveTo(canvas.width / 2 - 200, 140);
    ctx.lineTo(canvas.width / 2 + 200, 140);
    ctx.strokeStyle = '#2E7D32';
    ctx.lineWidth = 3;
    ctx.stroke();
    
    // Judul Sertifikat
    ctx.fillStyle = '#2E7D32';
    ctx.font = 'bold 60px "Times New Roman", serif';
    ctx.fillText('SERTIFIKAT PENGHARGAAN', canvas.width / 2, 260);
    
    // Diberikan kepada
    ctx.fillStyle = '#555';
    ctx.font = '24px Arial';
    ctx.fillText('Diberikan dengan bangga kepada:', canvas.width / 2, 340);
    
    // Nama Siswa
    ctx.fillStyle = '#FF9800';
    ctx.font = 'bold 70px "Times New Roman", serif';
    ctx.fillText(studentName, canvas.width / 2, 440);
    
    // Garis bawah nama
    ctx.beginPath();
    ctx.moveTo(canvas.width / 2 - 250, 460);
    ctx.lineTo(canvas.width / 2 + 250, 460);
    ctx.strokeStyle = '#ccc';
    ctx.lineWidth = 2;
    ctx.stroke();
    
    // Atas pencapaian
    ctx.fillStyle = '#555';
    ctx.font = '24px Arial';
    ctx.fillText('Atas kelulusan dan pemahamannya yang luar biasa dalam materi TIK:', canvas.width / 2, 530);
    
    // Judul Kuis
    ctx.fillStyle = '#333';
    ctx.font = 'bold 36px Arial';
    ctx.fillText('"' + quizTitle + '"', canvas.width / 2, 590);
    
    // Tanggal
    const today = new Date();
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    const dateString = today.toLocaleDateString('id-ID', options);
    
    ctx.fillStyle = '#555';
    ctx.font = 'italic 20px Arial';
    ctx.fillText('Diterbitkan pada: ' + dateString, canvas.width / 2, 680);
    
    // Tanda tangan
    ctx.beginPath();
    ctx.moveTo(canvas.width - 300, 680);
    ctx.lineTo(canvas.width - 100, 680);
    ctx.strokeStyle = '#333';
    ctx.lineWidth = 1;
    ctx.stroke();
    
    ctx.font = '18px Arial';
    ctx.fillText('Instruktur TIK', canvas.width - 200, 710);
    
    // Konversi ke gambar dan download
    const link = document.createElement('a');
    link.download = 'Sertifikat_TIK_' + studentName.replace(/\s+/g, '_') + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}
