# 📚 PerpusMini — Sistem Manajemen Buku Perpustakaan

Aplikasi web manajemen data buku perpustakaan untuk SMKN 40 Jakarta.  
Dibangun menggunakan **Laravel 13** dengan autentikasi dan CRUD lengkap.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 13 (PHP 8.2+)
- **Frontend:** Blade Template + Tailwind CSS
- **Database:** MySQL
- **Autentikasi:** Laravel Breeze

---

## 🚀 Cara Menjalankan Project

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Git

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/USERNAME/perpustakaan-mini.git
   cd perpustakaan-mini
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Install dependency JavaScript**
   ```bash
   npm install
   ```

4. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Setting database di file `.env`**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=perpustakaan_mini
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Buat database dan jalankan migrasi**
   ```bash
   php artisan migrate
   ```

   Atau import file SQL:
   ```bash
   mysql -u root -p perpustakaan_mini < database_buku.sql
   ```

7. **Build asset frontend**
   ```bash
   npm run build
   ```

8. **Jalankan server**
   ```bash
   php artisan serve
   ```

9. **Buka di browser**
   ```
   http://localhost:8000
   ```

---

## 📋 Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| **Login & Logout** | Autentikasi user dengan email dan password |
| **Register** | Pendaftaran akun baru dengan NISN |
| **Tambah Buku** | Form untuk menambahkan data buku baru |
| **Lihat Daftar Buku** | Tabel/kartu daftar semua buku |
| **Edit Buku** | Form untuk mengubah data buku |
| **Hapus Buku** | Menghapus data buku dengan konfirmasi |
| **Validasi Input** | Semua form memiliki validasi server-side |
| **Responsif** | Tampilan menyesuaikan desktop dan mobile |

---

## 📁 Struktur Project

```
perpustakaan-mini/
├── app/
│   ├── Http/Controllers/
│   │   ├── BukuController.php        # Controller CRUD buku
│   │   └── Auth/                     # Controller autentikasi
│   └── Models/
│       ├── Buku.php                  # Model buku
│       └── User.php                  # Model user
├── database/
│   └── migrations/                   # Migrasi tabel
├── resources/views/
│   ├── buku/
│   │   ├── index.blade.php           # Halaman daftar buku
│   │   ├── create.blade.php          # Form tambah buku
│   │   └── edit.blade.php            # Form edit buku
│   ├── auth/
│   │   ├── login.blade.php           # Halaman login
│   │   └── register.blade.php        # Halaman register
│   └── layouts/
│       ├── app.blade.php             # Layout utama
│       ├── guest.blade.php           # Layout login/register
│       └── navigation.blade.php      # Navigasi
├── routes/
│   └── web.php                       # Definisi route
└── database_buku.sql                 # Export database
```

---

## 👤 Dibuat oleh

Maliq Rizqi Ananda — Tugas Praktikum Web
