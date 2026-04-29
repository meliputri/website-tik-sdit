# Troubleshooting n8n HTTP 500 Error

## Error yang Anda Alami

```
HTTP 500 - "Error in workflow"
```

Ini berarti request berhasil sampai ke n8n, tapi ada error di dalam workflow n8n.

## Langkah-langkah Fix

### 1. Cek Execution Logs di n8n

**Cara:**
1. Buka n8n dashboard: `https://n8n-bwim753j5uts.runner.web.id`
2. Login ke akun Anda
3. Buka workflow yang menggunakan webhook: `/webhook/0c39ab02-7b84-4fe7-88ff-c41b21704ab4/chat`
4. Klik tab **"Executions"** atau **"History"**
5. Cari execution terbaru (yang baru saja gagal)
6. Klik execution tersebut untuk melihat detail

**Yang perlu dicek:**
- Node mana yang error (akan ada tanda merah ❌)
- Error message spesifik
- Input/output data di setiap node

### 2. Kemungkinan Penyebab & Solusi

#### ❌ Problem: Webhook Node Configuration

**Cek:**
- Method harus: `POST`
- Response Mode harus: **"Last Node"** (PENTING!)
- Path sudah benar

**Fix:**
1. Buka Webhook node
2. Pastikan Response Mode = "Last Node"
3. Save dan aktifkan ulang workflow

---

#### ❌ Problem: Node Setelah Webhook Error

**Cek:**
- Apakah ada node yang error (warna merah)?
- Apakah konfigurasi node sudah lengkap?

**Fix:**
- Klik node yang error
- Lihat error message
- Perbaiki konfigurasi sesuai error message

---

#### ❌ Problem: Missing API Key / Credential

Jika menggunakan AI node (OpenAI, Anthropic, dll):

**Cek:**
- Apakah API key sudah diisi?
- Apakah credential sudah di-setup?

**Fix:**
1. Buka node yang membutuhkan credential
2. Setup credential atau isi API key
3. Test node tersebut

---

#### ❌ Problem: Format Response Salah

**Yang diharapkan WordPress:**
```json
{
  "answer": "Jawaban dari n8n"
}
```

atau

```json
{
  "response": "Jawaban alternatif"
}
```

**Fix:**
- Pastikan node terakhir mengembalikan JSON dengan field `answer`, `response`, atau `text`

---

#### ❌ Problem: Workflow Tidak Mengembalikan Response

**Cek:**
- Apakah ada node yang mengembalikan response?
- Apakah Response Mode di Webhook = "Last Node"?

**Fix:**
- Pastikan workflow berakhir dengan node yang mengembalikan data
- Atau gunakan "Respond to Webhook" node di akhir

---

### 3. Buat Workflow Sederhana untuk Testing

Untuk memastikan integrasi berjalan, buat workflow minimal:

#### Workflow Minimal (Echo Test)

```
1. Webhook Node
   - Method: POST
   - Path: /chat
   - Response Mode: Last Node

2. Set Node
   - Set field: answer
   - Value: "Halo! Saya chatbot n8n. Pesan Anda: " + $json.message

3. (Response otomatis dikembalikan)
```

**Cara setup:**
1. Buat workflow baru di n8n
2. Tambahkan **Webhook** node:
   - Method: `POST`
   - Path: `/chat` (atau sesuai path Anda)
   - Response Mode: **"Last Node"** ⚠️ PENTING!
3. Tambahkan **Set** node:
   - Operation: "Set"
   - Set field `answer` = `"Test response: " + $json.message`
4. Aktifkan workflow
5. Copy webhook URL baru
6. Update di WordPress settings

#### Workflow dengan AI (OpenAI Example)

```
1. Webhook Node
   - Method: POST
   - Response Mode: Last Node

2. OpenAI Node
   - Model: gpt-3.5-turbo
   - Messages:
     - System: "Kamu adalah asisten TIK untuk SDIT Global Insan Madani"
     - User: {{ $json.message }}

3. Set Node
   - Set field: answer
   - Value: {{ $json.choices[0].message.content }}

4. (Response otomatis dikembalikan)
```

---

### 4. Test Workflow di n8n

**Sebelum test di WordPress:**

1. Di n8n, klik **"Test workflow"** atau **"Execute Workflow"**
2. Atau klik **"Test"** di Webhook node
3. Input test data:
   ```json
   {
     "message": "test",
     "timestamp": "2024-01-01 12:00:00",
     "source": "websiteku-wordpress"
   }
   ```
4. Lihat apakah workflow berjalan tanpa error
5. Cek output node terakhir - harus ada field `answer`

---

### 5. Common Errors & Solutions

#### Error: "Response Mode must be 'Last Node'"
**Fix:** Ubah Response Mode di Webhook node ke "Last Node"

#### Error: "No response node found"
**Fix:** Pastikan workflow berakhir dengan node yang mengembalikan data

#### Error: "API key is invalid"
**Fix:** Cek dan update API key di credential node

#### Error: "Model not found"
**Fix:** Pastikan model name benar (contoh: gpt-3.5-turbo, bukan gpt-3.5)

#### Error: "Required field is missing"
**Fix:** Cek apakah semua required fields di node sudah diisi

---

### 6. Debugging Tips

#### Enable Debug Mode di n8n
1. Buka workflow
2. Aktifkan "Save Execution Data" = "All"
3. Test workflow
4. Cek execution untuk melihat data di setiap node

#### Test dengan Postman/curl
Test webhook langsung tanpa WordPress:

```bash
curl -X POST "https://n8n-bwim753j5uts.runner.web.id/webhook/0c39ab02-7b84-4fe7-88ff-c41b21704ab4/chat" \
  -H "Content-Type: application/json" \
  -d '{
    "message": "test",
    "timestamp": "2024-01-01 12:00:00",
    "source": "websiteku-wordpress"
  }'
```

Jika ini juga error, berarti masalahnya di workflow n8n.

---

### 7. Checklist Sebelum Test

- [ ] Workflow status = **"Active"**
- [ ] Webhook node Method = **"POST"**
- [ ] Webhook node Response Mode = **"Last Node"**
- [ ] Semua node sudah dikonfigurasi dengan benar
- [ ] API keys/credentials sudah diisi (jika menggunakan AI)
- [ ] Node terakhir mengembalikan JSON dengan field `answer`
- [ ] Workflow sudah di-test di n8n dan berjalan tanpa error

---

### 8. Setelah Fix

1. **Aktifkan ulang workflow** di n8n
2. **Refresh browser** WordPress (Ctrl+F5)
3. **Test chatbot** di frontend
4. **Cek console** - seharusnya muncul: `✅ n8n response received`

---

## Masih Error?

Jika masih error setelah mengikuti semua langkah:

1. **Screenshot execution log** di n8n yang menunjukkan error detail
2. **Screenshot workflow** Anda (untuk melihat struktur)
3. **Copy error message** lengkap dari n8n

Dengan informasi ini, kita bisa troubleshoot lebih spesifik!

---

## Quick Reference: Format Request & Response

### Request dari WordPress ke n8n:
```json
{
  "message": "Pertanyaan user",
  "timestamp": "2024-01-01 12:00:00",
  "source": "websiteku-wordpress"
}
```

### Response yang Diharapkan dari n8n:
```json
{
  "answer": "Jawaban dari n8n"
}
```

atau

```json
{
  "response": "Jawaban alternatif"
}
```

atau

```json
{
  "text": "Jawaban lain"
}
```

---

**Catatan:** WordPress akan otomatis fallback ke rule-based system jika n8n error, jadi chatbot tetap berfungsi meskipun n8n bermasalah.

