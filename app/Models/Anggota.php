<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggota extends Model
{
    use SoftDeletes;

    /**
     * Paksa nama tabel (hindari pluralisasi salah → 'anggotas' sudah benar tapi route key tidak)
     * Override route key agar URL tetap /anggota/{anggota} bukan /anggota/{anggotum}
     */
    protected $table = 'anggotas';

    protected $fillable = ['user_id', 'nis', 'nama', 'kelas', 'no_hp', 'alamat'];

    /**
     * Relasi ke User (akun login anggota ini)
     * FK: anggotas.user_id → users.id
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nama relasi sesuai jobsheet: 'peminjaman'
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
