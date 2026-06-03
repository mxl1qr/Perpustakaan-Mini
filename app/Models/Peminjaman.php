<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans'; // Eksplisit karena Laravel salah pluralisasi kata bahasa Indonesia

    protected $fillable = [
        'user_id',
        'buku_id',
        'anggota_id',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_aktual',
        'denda',
        'status',
        'anggota_notified',
    ];
    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_aktual' => 'date',
    ];
    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->withTrashed();
    }
    // Relasi ke User (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
