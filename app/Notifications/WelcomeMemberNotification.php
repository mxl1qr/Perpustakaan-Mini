<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $token,
        public string $email,
        public string $nama,
        public string $nis,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $setPasswordUrl = url(route('password.set', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));

        return (new MailMessage)
            ->subject('Selamat Datang — Buat Password Akun Perpustakaan 40 Anda')
            ->greeting('Halo, ' . $this->nama . '!')
            ->line('Akun portal perpustakaan SMKN 40 Jakarta Anda telah berhasil dibuat oleh Admin.')
            ->line('**NIS / Username:** ' . $this->nis)
            ->line('Klik tombol di bawah untuk membuat password akun Anda.')
            ->action('Buat Password Sekarang', $setPasswordUrl)
            ->line('Tautan ini hanya berlaku selama **60 menit**.')
            ->line('Jika Anda merasa tidak mendaftarkan akun ini, abaikan email ini.')
            ->salutation('Salam, Tim Perpustakaan 40 — SMKN 40 Jakarta');
    }
}
