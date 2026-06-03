<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi input login.
     * Field "email" menerima NIS atau alamat email (bukan validated as email format).
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string'],  // terima NIS atau email
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Autentikasi dengan dukungan NIS atau email.
     *
     * Alur:
     * 1. Jika input mengandung '@' → anggap sebagai email → Auth::attempt biasa
     * 2. Jika tidak mengandung '@' → anggap sebagai NIS → cari user berdasarkan kolom `nisn`
     *    kemudian attempt dengan email yang ditemukan
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input    = $this->string('email')->trim()->value();
        $password = $this->input('password');

        // Tentukan apakah input adalah email atau NIS
        if (str_contains($input, '@')) {
            // Login via email (admin atau anggota yang tahu emailnya)
            $credentials = ['email' => $input, 'password' => $password];
        } else {
            // Login via NIS → cari user berdasarkan kolom nisn
            $user = User::where('nisn', $input)->first();

            if (!$user) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => 'NIS tidak ditemukan. Pastikan NIS sudah terdaftar di sistem.',
                ]);
            }

            $credentials = ['email' => $user->email, 'password' => $password];
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Cek admin_verified_at
        if (is_null(Auth::user()->admin_verified_at)) {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Akun Anda belum diverifikasi oleh admin. Silakan tunggu persetujuan.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
