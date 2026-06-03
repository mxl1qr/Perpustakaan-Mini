<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jumlahBuku    = \App\Models\Buku::count();
    $jumlahAnggota = \App\Models\Anggota::count(); // sudah exclude soft-deleted otomatis
    return view('welcome', compact('jumlahBuku', 'jumlahAnggota'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('buku', BukuController::class);
    // Anggota pakai manual routes karena Laravel plural 'Anggota' → 'anggotum' (salah)
    Route::get('anggota',                  [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('anggota',                 [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/{anggota}',        [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('anggota/{anggota}',        [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/{anggota}',                  [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::post('anggota/{anggota}/resend-welcome', [AnggotaController::class, 'resendWelcome'])->name('anggota.resend-welcome');
    Route::post('anggota/{anggota}/verify', [AnggotaController::class, 'verify'])->name('anggota.verify');
    Route::resource('peminjaman', PeminjamanController::class);
    // Route kembalikan buku — sesuai jobsheet (POST terpisah)
    Route::post('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');
    Route::post('peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
    Route::delete('peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::resource('kategori', KategoriController::class);
    // Route denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::post('/denda/settings', [DendaController::class, 'updateSettings'])->name('denda.settings');
    Route::post('/denda/{peminjaman}/lunaskan', [DendaController::class, 'lunaskan'])->name('denda.lunaskan');
    // Route polling notifikasi realtime
    Route::get('/notifications/pending', [PeminjamanController::class, 'pendingNotifications'])->name('notifications.pending');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak-transaksi', [LaporanController::class, 'cetakTransaksi'])->name('laporan.cetak-transaksi');
    Route::get('/laporan/cetak-denda', [LaporanController::class, 'cetakDenda'])->name('laporan.cetak-denda');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route Khusus Portal Siswa (Anggota)
Route::middleware(['auth', 'role:anggota'])->prefix('portal')->name('anggota.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AnggotaPortalController::class, 'index'])->name('portal');
    Route::get('/katalog', [\App\Http\Controllers\AnggotaPortalController::class, 'katalog'])->name('katalog');
    Route::get('/katalog/{id}', [\App\Http\Controllers\AnggotaPortalController::class, 'showBuku'])->name('buku.show');
    Route::post('/katalog/{id}/pinjam', [\App\Http\Controllers\AnggotaPortalController::class, 'pinjamBuku'])->name('buku.pinjam');
    Route::post('/katalog/{id}/favorit', [\App\Http\Controllers\AnggotaPortalController::class, 'toggleFavorit'])->name('buku.favorit');
    Route::get('/favorit', [\App\Http\Controllers\AnggotaPortalController::class, 'favorit'])->name('favorit');
    Route::get('/keranjang', [\App\Http\Controllers\AnggotaPortalController::class, 'keranjang'])->name('keranjang');
    Route::delete('/keranjang/{id}/hapus', [\App\Http\Controllers\AnggotaPortalController::class, 'hapusKeranjang'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [\App\Http\Controllers\AnggotaPortalController::class, 'checkoutKeranjang'])->name('keranjang.checkout');
    Route::get('/transaksi', [\App\Http\Controllers\AnggotaPortalController::class, 'transaksi'])->name('transaksi');
    Route::get('/transaksi/cetak', [\App\Http\Controllers\AnggotaPortalController::class, 'cetakTransaksi'])->name('transaksi.cetak');
});

require __DIR__ . '/auth.php';
