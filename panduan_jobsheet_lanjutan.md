# 📚 Panduan Step-by-Step: Jobsheet Lanjutan Perpustakaan

> ⚠️ **Cara baca panduan ini:** Setiap langkah saya tulis **kode lengkap** yang harus kamu masukkan sendiri ke file yang disebutkan. Kita jalan satu-satu, pelan-pelan.

---

## 🗺️ Peta Perjalanan (3 Fase)

```
Fase 1: Database Baru        → Bikin tabel kategori, anggota, peminjaman
Fase 2: Logika Bisnis        → Fitur pinjam buku & kembalikan + denda
Fase 3: Laporan & Dashboard  → Tampilkan statistik & riwayat
```

---

## ⚡ Penyesuaian Project Kamu

Sebelum mulai, ini yang **sudah ada** di project kamu vs yang **baru di jobsheet**:

| Yang Sudah Ada | Catatan |
|---|---|
| Tabel `users` (id, name, nisn, email, password) | ✅ Ini yang dipakai sebagai "petugas/admin" login |
| Tabel `bukus` (id, judul, pengarang, tahun_terbit, stok) | ✅ Nanti perlu ditambah kolom `kategori_id` |
| Model `User`, Model `Buku`, `BukuController` | ✅ Sudah ada |

| Yang Perlu Dibuat | Keterangan |
|---|---|
| Tabel `kategoris` | Kategori buku (fiksi, non-fiksi, dll) |
| Tabel `anggotas` | Data anggota perpustakaan (bukan user login!) |
| Tabel `peminjamans` | Rekap transaksi peminjaman |
| Kolom baru di `bukus` | Tambah `kategori_id` |

> 💡 **Penting:** `anggota` ≠ `user`. `user` = petugas yang login ke sistem. `anggota` = siswa/orang yang meminjam buku.

---

# FASE 1: Database & Relasi

## Step 1.1 — Buat Migration Tabel `kategoris`

**File baru yang dibuat via terminal** (jalankan di terminal):
```bash
php artisan make:migration create_kategoris_table
```

Setelah file terbuat di `database/migrations/`, isi dengan kode ini:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
```

---

## Step 1.2 — Buat Migration Tabel `anggotas`

```bash
php artisan make:migration create_anggotas_table
```

Isi file migration-nya:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();   // Nomor induk siswa
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
```

---

## Step 1.3 — Tambah Kolom `kategori_id` ke Tabel `bukus`

Karena tabel `bukus` **sudah ada** (tidak kita drop), kita pakai migration *alter*:

```bash
php artisan make:migration add_kategori_id_to_bukus_table
```

Isi file-nya:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Tambahkan setelah kolom 'pengarang'
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->after('pengarang')
                  ->constrained('kategoris')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Kategori::class);
            $table->dropColumn('kategori_id');
        });
    }
};
```

---

## Step 1.4 — Buat Migration Tabel `peminjamans`

```bash
php artisan make:migration create_peminjamans_table
```

Isi file-nya:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');         // Petugas yang mencatat
            $table->foreignId('buku_id')->constrained('bukus');         // Buku yang dipinjam
            $table->foreignId('anggota_id')->constrained('anggotas');   // Anggota yang meminjam
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');                            // Deadline pengembalian (otomatis +7 hari)
            $table->date('tanggal_dikembalikan')->nullable();           // Tanggal aktual dikembalikan
            $table->decimal('denda', 10, 2)->default(0);               // Denda keterlambatan
            $table->enum('status', ['Dipinjam', 'Kembali'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
```

---

## Step 1.5 — Jalankan Semua Migration

```bash
php artisan migrate
```

---

## Step 1.6 — Buat Model `Kategori`

```bash
php artisan make:model Kategori
```

File: `app/Models/Kategori.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];

    // Satu kategori punya banyak buku
    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
```

---

## Step 1.7 — Buat Model `Anggota`

```bash
php artisan make:model Anggota
```

File: `app/Models/Anggota.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['nim', 'nama', 'alamat', 'no_hp'];

    // Satu anggota bisa punya banyak peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
```

---

## Step 1.8 — Buat Model `Peminjaman`

```bash
php artisan make:model Peminjaman
```

File: `app/Models/Peminjaman.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = [
        'user_id',
        'buku_id',
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'denda',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'        => 'date',
        'tanggal_kembali'       => 'date',
        'tanggal_dikembalikan'  => 'date',
    ];

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi ke User (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## Step 1.9 — Update Model `Buku` (tambah relasi)

File: `app/Models/Buku.php` — **edit yang sudah ada**, tambahkan relasi:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'pengarang',
        'tahun_terbit',
        'stok',
        'kategori_id',      // ← TAMBAHAN BARU
    ];

    // Buku dimiliki oleh satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Satu buku bisa punya banyak transaksi peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
```

---

✅ **Fase 1 selesai!** Setelah ini kita masuk Fase 2 (Controller Peminjaman & Pengembalian). Kabari saya kalau sudah selesai memasukkan semua kode Fase 1 ya!

---

# FASE 2: Logika Bisnis (Peminjaman & Pengembalian)

> Tunggu konfirmasi selesai Fase 1 dulu sebelum lanjut ke sini.

## Step 2.1 — Buat Controller untuk Anggota

```bash
php artisan make:controller AnggotaController --resource
```

---

## Step 2.2 — Buat Controller untuk Peminjaman

```bash
php artisan make:controller PeminjamanController --resource
```

---

## Step 2.3 — Tambah Routes

File: `routes/web.php` — tambahkan di dalam `Route::middleware('auth')->group(...)`:

```php
Route::resource('anggota', AnggotaController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::resource('kategori', KategoriController::class);
```

Dan tambahkan import controller di bagian atas:
```php
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriController;
```

---

## Step 2.4 — Isi PeminjamanController

File: `app/Http/Controllers/PeminjamanController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan daftar peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'anggota', 'user'])
                                  ->latest()
                                  ->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    // Tampilkan form tambah peminjaman
    public function create()
    {
        $bukus    = Buku::where('stok', '>', 0)->get();  // Hanya buku yang masih ada stok
        $anggotas = Anggota::all();
        return view('peminjaman.create', compact('bukus', 'anggotas'));
    }

    // Simpan data peminjaman baru
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'buku_id'       => 'required|exists:bukus,id',
            'anggota_id'    => 'required|exists:anggotas,id',
            'tanggal_pinjam'=> 'required|date',
        ]);

        // 2. Cek stok buku
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 3. Simpan peminjaman (deadline otomatis +7 hari)
        Peminjaman::create([
            'user_id'        => auth()->id(),
            'buku_id'        => $request->buku_id,
            'anggota_id'     => $request->anggota_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali'=> Carbon::parse($request->tanggal_pinjam)->addDays(7),
            'status'         => 'Dipinjam',
        ]);

        // 4. Kurangi stok buku
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Buku berhasil dipinjam!');
    }

    // Proses pengembalian buku (update status + hitung denda)
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Jika sudah dikembalikan, tolak
        if ($peminjaman->status === 'Kembali') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        // 1. Hitung denda
        $tanggal_kembali       = Carbon::parse($peminjaman->tanggal_kembali);
        $tanggal_dikembalikan  = now();
        $denda = 0;

        if ($tanggal_dikembalikan->gt($tanggal_kembali)) {
            $selisih_hari = $tanggal_dikembalikan->diffInDays($tanggal_kembali);
            $denda = $selisih_hari * 1000; // Rp 1.000/hari
        }

        // 2. Update data peminjaman
        $peminjaman->update([
            'tanggal_dikembalikan' => $tanggal_dikembalikan,
            'denda'                => $denda,
            'status'               => 'Kembali',
        ]);

        // 3. Kembalikan stok buku
        $peminjaman->buku->increment('stok');

        $pesan = 'Buku berhasil dikembalikan!';
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $pesan);
    }
}
```

---

# FASE 3: Dashboard & UI

> Akan dibahas setelah Fase 2 selesai. Isinya: card statistik di dashboard, tabel riwayat peminjaman, dan update navbar.

---

## 📋 ERD Singkat (Gambaran Relasi)

```
users ──────────────────────────────┐
  id, name, nisn, email, password   │ (petugas yang login)
                                    │
kategoris ──────────────────────────┤
  id, nama_kategori                 │
        │ hasMany                   │
        ▼                           │
bukus ──────────────────────────────┤
  id, judul, pengarang,             │
  tahun_terbit, stok, kategori_id   │
        │ hasMany                   │
        ▼                           │
peminjamans ◄───────────────────────┘
  id, user_id, buku_id, anggota_id,
  tanggal_pinjam, tanggal_kembali,
  tanggal_dikembalikan, denda, status
        ▲
        │ hasMany
anggotas
  id, nim, nama, alamat, no_hp
```
