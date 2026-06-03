<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id',
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'deskripsi',
        'tahun_terbit',
        'stok',
        'cover',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Nama relasi sesuai jobsheet: 'peminjaman' (bukan 'peminjamans')
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
