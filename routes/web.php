<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuBootstrapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('buku.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('buku', BukuController::class);

    // ── Bootstrap version routes (untuk perbandingan) ──
    Route::get('/buku-bootstrap', [BukuBootstrapController::class, 'index'])->name('buku-bootstrap.index');
    Route::get('/buku-bootstrap/create', [BukuBootstrapController::class, 'create'])->name('buku-bootstrap.create');
    Route::get('/buku-bootstrap/{buku}/edit', [BukuBootstrapController::class, 'edit'])->name('buku-bootstrap.edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
