<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nisn', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Relasi ke tabel Anggota.
     * Menggunakan user_id (FK di tabel anggotas) sebagai penghubung utama.
     * Fallback: cari via nisn = nis jika user_id belum di-set.
     */
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    /**
     * Relasi ke buku favorit.
     */
    public function bukuFavorit()
    {
        return $this->belongsToMany(Buku::class, 'buku_favorits', 'user_id', 'buku_id')->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Override default email verification to use the Queued version
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailQueued);
    }
}
