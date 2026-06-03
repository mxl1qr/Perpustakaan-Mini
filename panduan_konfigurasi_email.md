# Panduan Konfigurasi Email Laravel — Dari Dev ke Production

## Gambaran Umum

Laravel mengirim email melalui **driver** yang dikonfigurasi di `.env`. Pilih sesuai kebutuhan:

| Kondisi | Driver yang Dipakai |
|---|---|
| Testing lokal (tidak mau email nyata keluar) | **Mailtrap** |
| Production, pakai Gmail | **SMTP Gmail** |
| Production skala besar / profesional | **Mailgun / Resend** |
| Hanya ingin cek di log file saja | **Log** |

---

## Tahap 1: Testing Lokal — Mailtrap (RECOMMENDED untuk dev)

> [!TIP]
> Mailtrap adalah "kotak surat palsu" yang menangkap semua email tanpa benar-benar mengirimnya ke inbox nyata. **GRATIS** dan sangat mudah.

### Langkah-langkah:

**1. Daftar di [mailtrap.io](https://mailtrap.io)** (gratis, pakai email apa saja)

**2. Masuk → Email Testing → My Inbox → klik "Show Credentials"**

Akan muncul credential seperti ini:
```
Host:       sandbox.smtp.mailtrap.io
Port:       2525
Username:   abc123def456  ← (unik per akun)
Password:   xyz789ghi012  ← (unik per akun)
```

**3. Isi `.env` Anda:**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=abc123def456
MAIL_PASSWORD=xyz789ghi012
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@perpusmini.sch.id"
MAIL_FROM_NAME="PerpusMini SMKN 40"
```

**4. Test kirim email:**
```bash
php artisan tinker
> Mail::raw('Test email!', fn($m) => $m->to('test@example.com')->subject('Tes'));
```

Email akan masuk ke **Inbox Mailtrap** Anda (bukan ke email sungguhan).

---

## Tahap 2: Production — Gmail SMTP

> [!WARNING]
> Gmail membatasi penggunaan SMTP untuk aplikasi. Anda **TIDAK BISA** pakai password biasa Gmail. Harus pakai **App Password** khusus.

### Syarat:
- Akun Gmail yang sudah aktifkan **2-Factor Authentication (2FA)**

### Langkah membuat App Password:

1. Buka [myaccount.google.com/security](https://myaccount.google.com/security)
2. Scroll ke **"How you sign in to Google"**
3. Klik **"2-Step Verification"** → pastikan sudah ON
4. Scroll ke bawah → klik **"App passwords"**
5. Pilih app: **Mail** | Pilih device: **Other (custom name)** → ketik `PerpusMini`
6. Klik **Generate** → Google akan tampilkan kode **16 karakter** (contoh: `abcd efgh ijkl mnop`)
7. **Simpan kode ini**, karena tidak bisa dilihat lagi!

### Isi `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD="abcdefghijklmnop"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="PerpusMini SMKN 40"
```

> [!NOTE]
> `MAIL_PASSWORD` diisi dengan App Password 16 karakter (tanpa spasi), bukan password Gmail biasa!

---

## Tahap 3: Production Profesional — Mailgun / Resend (Terbaik untuk Production)

> [!TIP]
> Lebih andal dari Gmail untuk production karena dirancang khusus untuk pengiriman email massal.

### Opsi A: Resend (termudah, gratis s/d 3.000 email/bulan)

1. Daftar di [resend.com](https://resend.com)
2. Buat API Key
3. Isi `.env`:
```env
MAIL_MAILER=resend
RESEND_KEY=re_xxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS="noreply@domainanda.com"
MAIL_FROM_NAME="PerpusMini SMKN 40"
```
4. Install package:
```bash
composer require resend/resend-laravel
```

### Opsi B: Mailgun (gratis 1.000 email/bulan)

1. Daftar di [mailgun.com](https://mailgun.com)
2. Tambah domain → verifikasi DNS
3. Isi `.env`:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.domainanda.com
MAILGUN_SECRET=key-xxxxxxxxxxxxxxxxxxxx
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS="noreply@domainanda.com"
MAIL_FROM_NAME="PerpusMini SMKN 40"
```
4. Install package:
```bash
composer require symfony/mailgun-mailer symfony/http-client
```

---

## Konfigurasi Tambahan yang Penting

### Pastikan APP_URL sudah benar di `.env`:
```env
APP_URL=https://domainanda.com
```
> Ini digunakan dalam link email (reset password, verifikasi). Jika salah, link di email akan mengarah ke URL yang salah!

### Untuk lokal pakai:
```env
APP_URL=http://localhost:8000
```

---

## Checklist Deployment Email ✅

```
[ ] MAIL_FROM_ADDRESS diisi email yang valid (bukan placeholder)
[ ] MAIL_FROM_NAME diisi nama yang informatif
[ ] APP_URL diisi URL production yang benar
[ ] Test kirim email via php artisan tinker sebelum deploy
[ ] Pastikan queue worker berjalan jika menggunakan QUEUE_CONNECTION=database
```

> [!IMPORTANT]
> Untuk kenyamanan, gunakan **Mailtrap** saat development lokal, lalu ganti ke **Gmail SMTP** atau **Resend** saat sudah deploy ke server production.
