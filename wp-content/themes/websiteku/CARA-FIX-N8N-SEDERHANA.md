# 🛠️ Cara Fix Error n8n - Panduan Sederhana

## ❌ Masalah yang Terjadi

Error di node "Postgres Chat Memory" dengan pesan:
```
Key parameter is empty
```

## ✅ Solusi Sederhana (Ikuti Langkah Demi Langkah)

### Langkah 1: Buka Node yang Error

1. Di n8n, buka workflow yang error
2. Cari node yang **warna merah** atau ada tanda **❌**
3. Node tersebut bernama **"Postgres Chat Memory"**
4. **Klik sekali** pada node tersebut (node akan ter-highlight)

---

### Langkah 2: Buka Field "Key"

1. Setelah klik node "Postgres Chat Memory", akan muncul panel di kanan
2. Di panel tersebut, cari field yang namanya **"Key"**
3. Field "Key" ini akan terlihat seperti kotak input teks
4. Di dalam kotak tersebut ada tulisan: `{{ $json.sessionId }}`
5. **Tulisan ini berwarna merah** (menandakan error)

---

### Langkah 3: Ganti Isi Field "Key"

1. **Klik** di dalam kotak field "Key" (yang berisi `{{ $json.sessionId }}`)
2. **Hapus semua** tulisan yang ada di dalamnya (Ctrl+A lalu Delete)
3. **Ketik** teks berikut (copy-paste juga bisa):
   ```
   wordpress-chat
   ```
4. Pastikan tidak ada spasi di awal atau akhir
5. Field "Key" sekarang berisi: `wordpress-chat` (bukan expression lagi)

---

### Langkah 4: Simpan Perubahan

1. Setelah field "Key" sudah diisi dengan `wordpress-chat`
2. **Klik tombol "Save"** atau **"Done"** di node tersebut
3. Atau klik di area kosong di luar node untuk auto-save

---

### Langkah 5: Aktifkan Workflow

1. Pastikan workflow status = **"Active"** (bukan "Inactive")
2. Jika status "Inactive", klik tombol **"Active"** di pojok kanan atas
3. Workflow sekarang sudah aktif dan siap digunakan

---

### Langkah 6: Test Workflow

1. Di n8n, klik tombol **"Test workflow"** atau **"Execute Workflow"**
2. Atau klik tombol **"Test"** di Webhook node
3. Lihat apakah workflow berjalan **tanpa error**
4. Jika masih error, cek node mana yang masih merah

---

### Langkah 7: Test di WordPress

1. **Refresh browser** WordPress (tekan Ctrl+F5)
2. Buka website frontend (bukan admin)
3. Scroll ke bawah, cari tombol **chatbot** (ikon 💬 di pojok kanan bawah)
4. **Klik** tombol chatbot
5. **Ketik** pesan uji, misalnya: "Halo" atau "Test"
6. **Tunggu** response dari chatbot

---

## 🎯 Yang Harus Terjadi Setelah Fix

✅ Node "Postgres Chat Memory" **tidak lagi merah**
✅ Workflow bisa di-test **tanpa error**
✅ Chatbot WordPress **menerima response** dari n8n
✅ Di browser console muncul: `✅ n8n response received`

---

## 📸 Visual Guide (Jika Masih Bingung)

### Sebelum Fix:
```
Field "Key" berisi: {{ $json.sessionId }}
                    ↑
              (warna merah, error)
```

### Sesudah Fix:
```
Field "Key" berisi: wordpress-chat
                    ↑
              (teks biasa, tidak error)
```

---

## ❓ FAQ (Pertanyaan Umum)

### Q: Kenapa harus ganti jadi "wordpress-chat"?
**A:** Karena field "Key" membutuhkan nilai yang jelas. Expression `{{ $json.sessionId }}` mencari data yang tidak ada, jadi kita ganti dengan teks tetap.

### Q: Apakah "wordpress-chat" harus persis seperti itu?
**A:** Tidak harus persis. Bisa pakai teks apapun, misalnya: `chat-session`, `test-chat`, `my-chat`, dll. Yang penting **bukan expression** (yang pakai `{{ }}`).

### Q: Setelah fix, masih error?
**A:** 
1. Pastikan sudah klik "Save" setelah ganti field
2. Pastikan workflow status = "Active"
3. Cek node lain apakah ada yang masih error (warna merah)
4. Test workflow di n8n dulu sebelum test di WordPress

### Q: Apakah ini fix permanent?
**A:** Untuk testing, ini sudah cukup. Untuk production nanti, bisa di-improve dengan session ID yang lebih dinamis, tapi untuk sekarang ini sudah cukup.

---

## 🆘 Masih Error? Cek Ini:

1. ✅ Field "Key" sudah diisi dengan teks (bukan expression)?
2. ✅ Sudah klik "Save"?
3. ✅ Workflow status = "Active"?
4. ✅ Node lain tidak ada yang error?
5. ✅ Sudah test workflow di n8n dan berhasil?

---

## 📝 Checklist Fix

- [ ] Buka node "Postgres Chat Memory"
- [ ] Ganti field "Key" dari `{{ $json.sessionId }}` menjadi `wordpress-chat`
- [ ] Save node
- [ ] Pastikan workflow Active
- [ ] Test workflow di n8n (harus berhasil)
- [ ] Refresh browser WordPress
- [ ] Test chatbot di frontend
- [ ] Cek console - harus muncul `✅ n8n response received`

---

**Catatan:** Setelah fix ini, chatbot akan menggunakan session ID yang sama untuk semua chat. Ini cukup untuk testing. Untuk production nanti bisa di-improve lagi.

