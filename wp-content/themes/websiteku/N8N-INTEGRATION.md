# Integrasi n8n dengan Chatbot Websiteku

Dokumentasi ini menjelaskan cara mengintegrasikan chatbot WordPress dengan n8n untuk mendapatkan respons berbasis AI atau workflow automation.

## Fitur

- ✅ Integrasi n8n webhook untuk chatbot
- ✅ Fallback otomatis ke rule-based jika n8n gagal/timeout
- ✅ Proxy endpoint WordPress untuk keamanan
- ✅ Konfigurasi mudah melalui WordPress Admin
- ✅ Support timeout yang dapat dikonfigurasi

## Cara Setup

### 1. Setup n8n Workflow

1. **Buat workflow baru di n8n**
   - Login ke n8n instance Anda
   - Buat workflow baru
   - Tambahkan node **Webhook** sebagai trigger

2. **Konfigurasi Webhook Node**
   - Method: `POST`
   - Path: `/chatbot` (atau path lain sesuai kebutuhan)
   - Response Mode: `Last Node`
   - Aktifkan workflow

3. **Tambahkan Node untuk Processing**
   - Setelah Webhook, tambahkan node sesuai kebutuhan:
     - **AI/LLM Node** (OpenAI, Anthropic, dll) untuk AI responses
     - **Function Node** untuk custom logic
     - **HTTP Request** untuk memanggil API eksternal
     - **Code Node** untuk processing data

4. **Format Response**
   n8n harus mengembalikan response dalam format JSON. WordPress akan mencari field berikut (dalam urutan prioritas):
   - `answer` (prioritas tertinggi)
   - `response`
   - `text`
   - String langsung
   - Array pertama

   **Contoh Response:**
   ```json
   {
     "answer": "Ini adalah jawaban dari n8n!"
   }
   ```

   atau

   ```json
   {
     "response": "Jawaban alternatif"
   }
   ```

5. **Copy Webhook URL**
   - Setelah workflow aktif, copy URL webhook
   - Format: `https://your-n8n-instance.com/webhook/chatbot`

### 2. Konfigurasi di WordPress

1. **Buka WordPress Admin**
   - Login ke WordPress Admin
   - Pergi ke **Pengaturan Tema** → **Chatbot n8n Integration**

2. **Isi Pengaturan**
   - **n8n Webhook URL**: Paste URL webhook dari n8n
   - **Aktifkan n8n**: Centang untuk mengaktifkan
   - **Timeout (detik)**: Waktu maksimal menunggu response (default: 5 detik)

3. **Simpan Pengaturan**
   - Klik "Simpan Pengaturan"
   - Chatbot akan otomatis menggunakan n8n jika diaktifkan

### 3. Testing

1. **Test di Frontend**
   - Buka website frontend
   - Klik tombol chatbot di pojok kanan bawah
   - Ketik pertanyaan
   - Chatbot akan memanggil n8n dan menampilkan response

2. **Test Fallback**
   - Matikan n8n workflow atau set timeout sangat pendek
   - Chatbot akan otomatis fallback ke rule-based system

## Format Request ke n8n

WordPress mengirim request ke n8n dengan format:

```json
{
  "message": "Pertanyaan user",
  "timestamp": "2024-01-01 12:00:00",
  "source": "websiteku-wordpress"
}
```

Anda bisa menggunakan data ini di n8n workflow untuk processing.

## Format Response dari n8n

n8n harus mengembalikan response dalam format JSON dengan salah satu field berikut:

**Prioritas 1:**
```json
{
  "answer": "Jawaban dari n8n"
}
```

**Prioritas 2:**
```json
{
  "response": "Jawaban alternatif"
}
```

**Prioritas 3:**
```json
{
  "text": "Jawaban lain"
}
```

**Prioritas 4:**
```json
"String langsung"
```

**Prioritas 5:**
```json
["Array pertama akan digunakan"]
```

## Fallback Behavior

Jika n8n:
- ❌ Tidak diaktifkan
- ❌ Webhook URL kosong
- ❌ Request timeout
- ❌ Mengembalikan error
- ❌ Tidak dapat diakses

Maka chatbot akan **otomatis fallback** ke sistem rule-based yang sudah ada (menggunakan data dari `chatbot-data.js` dan Custom Post Type "Chatbot Q&A").

## Troubleshooting

### Chatbot tidak memanggil n8n

1. ✅ Pastikan "Aktifkan n8n" sudah dicentang
2. ✅ Pastikan Webhook URL sudah diisi dan valid
3. ✅ Pastikan n8n workflow sudah aktif
4. ✅ Cek browser console untuk error messages

### n8n timeout

1. ✅ Periksa koneksi ke n8n instance
2. ✅ Tingkatkan timeout di pengaturan (default: 5 detik)
3. ✅ Periksa apakah n8n workflow terlalu lama processing

### Response tidak muncul

1. ✅ Pastikan n8n mengembalikan response dalam format JSON yang benar
2. ✅ Cek n8n workflow execution logs
3. ✅ Pastikan response mode di Webhook node adalah "Last Node"

### CORS Error

Jika ada CORS error, pastikan:
- ✅ Menggunakan WordPress proxy endpoint (sudah otomatis)
- ✅ n8n instance mengizinkan request dari domain WordPress

## Contoh n8n Workflow

### Workflow Sederhana dengan AI

1. **Webhook** (Trigger)
   - Method: POST
   - Path: `/chatbot`

2. **OpenAI Node** (atau AI provider lain)
   - Model: gpt-3.5-turbo
   - Prompt: "Jawab pertanyaan tentang TIK: {{ $json.message }}"
   - System: "Kamu adalah asisten TIK untuk SDIT Global Insan Madani"

3. **Set Node** (Format Response)
   - Set field `answer` = `{{ $json.choices[0].message.content }}`

4. **Return Response**
   - Response akan otomatis dikembalikan ke WordPress

### Workflow dengan Database Lookup

1. **Webhook** (Trigger)
2. **Function Node** - Extract keywords dari message
3. **PostgreSQL/MySQL Node** - Query database untuk jawaban
4. **IF Node** - Jika ditemukan, return dari DB; jika tidak, lanjut ke AI
5. **OpenAI Node** - Generate answer jika tidak ada di DB
6. **Set Node** - Format response
7. **Return Response**

## Security Notes

- ✅ Webhook URL disimpan di WordPress database (tidak exposed ke frontend)
- ✅ Request ke n8n dilakukan via WordPress proxy (menggunakan nonce)
- ✅ Nonce verification untuk mencegah abuse
- ✅ Timeout protection untuk mencegah hanging requests

## Support

Jika ada pertanyaan atau masalah, silakan:
1. Cek browser console untuk error messages
2. Cek n8n execution logs
3. Pastikan semua konfigurasi sudah benar
4. Test dengan rule-based terlebih dahulu untuk memastikan chatbot berfungsi

---

**Catatan:** Integrasi ini memungkinkan chatbot untuk menggunakan AI atau workflow automation dari n8n, sambil tetap mempertahankan fallback ke sistem rule-based yang sudah ada.

