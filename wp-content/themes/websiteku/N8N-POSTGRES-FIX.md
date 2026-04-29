# Fix Postgres Chat Memory Error

## Error yang Terjadi

```
Key parameter is empty
```

Di node "Postgres Chat Memory", field "Key" menggunakan `{{ $json.sessionId }}` tapi `sessionId` tidak ada di data yang masuk.

## Solusi

### Solusi 1: Set Session ID Statis (Recommended untuk Testing)

1. Buka node "Postgres Chat Memory"
2. Di field "Key", ganti expression dengan nilai statis:
   ```
   wordpress-chat
   ```
   atau
   ```
   websiteku-session
   ```
3. Save node
4. Test workflow

**Catatan:** Ini akan menggunakan session ID yang sama untuk semua chat dari WordPress. Untuk production, gunakan Solusi 2.

---

### Solusi 2: Generate Session ID dari Data yang Masuk

1. Buka node "Postgres Chat Memory"
2. Di field "Key", gunakan expression:
   ```
   {{ 'wp-' + $now.toISO() }}
   ```
   atau
   ```
   {{ $json.timestamp || $now.toISO() }}
   ```
   atau jika ingin menggunakan timestamp dari request:
   ```
   {{ 'wp-' + $json.timestamp.replace(/[^0-9]/g, '') }}
   ```

3. Save node
4. Test workflow

**Catatan:** Ini akan membuat session ID unik untuk setiap request.

---

### Solusi 3: Bypass Chat Memory (Quick Testing)

Jika chat memory tidak critical untuk testing:

1. **Nonaktifkan node "Postgres Chat Memory"**:
   - Klik node tersebut
   - Klik tombol "Disable" atau hapus sementara
   
2. **Pastikan workflow tetap mengembalikan response**:
   - Node terakhir harus mengembalikan JSON dengan field `answer`
   - Pastikan "Google Gemini Chat Model" output di-format dengan benar

3. **Test workflow**:
   - Harus berjalan tanpa error
   - Response harus ada field `answer`

4. **Fix chat memory nanti** setelah workflow berjalan

---

### Solusi 4: Tambahkan Session ID di Request dari WordPress

Jika ingin menggunakan session ID yang dikirim dari WordPress:

1. **Update WordPress code** untuk mengirim sessionId:
   - Bisa generate sessionId di JavaScript
   - Atau gunakan user ID jika user logged in
   - Atau gunakan timestamp

2. **Update n8n workflow**:
   - Pastikan data yang masuk ke "Postgres Chat Memory" memiliki field `sessionId`
   - Expression `{{ $json.sessionId }}` akan bekerja

---

## Format Data yang Masuk ke Postgres Chat Memory

Data dari WordPress ke n8n:
```json
{
  "message": "Pertanyaan user",
  "timestamp": "2024-01-01 12:00:00",
  "source": "websiteku-wordpress"
}
```

Jika ingin menambahkan sessionId, bisa update WordPress code untuk mengirim:
```json
{
  "message": "Pertanyaan user",
  "timestamp": "2024-01-01 12:00:00",
  "source": "websiteku-wordpress",
  "sessionId": "unique-session-id"
}
```

---

## Quick Fix untuk Testing

**Langkah cepat:**
1. Buka node "Postgres Chat Memory"
2. Field "Key" → ganti dengan: `wordpress-chat`
3. Save
4. Test workflow

Ini akan membuat semua chat dari WordPress menggunakan session ID yang sama, yang cukup untuk testing.

---

## Setelah Fix

1. **Test workflow di n8n** - harus berjalan tanpa error
2. **Test di WordPress** - chatbot harus menerima response dari n8n
3. **Cek console** - seharusnya muncul: `✅ n8n response received`

---

## Catatan

- Chat memory berguna untuk context conversation
- Untuk testing, bisa bypass dulu
- Untuk production, gunakan session ID yang unik per user/session

