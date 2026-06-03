<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * - Setelah register, role otomatis = 'anggota'
     * - Cek apakah NISN sudah terdaftar sebagai Anggota di tabel anggotas
     * - Jika ada, user langsung terasosiasi dengan record anggota tersebut
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nisn'     => ['required', 'string', 'min:5', 'unique:users,nisn'],
            'kelas'    => ['required', 'string', 'max:20'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user baru dengan role anggota
        $user = User::create([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        // Cek apakah ada record Anggota yang NIS-nya cocok dengan NISN yang didaftarkan
        $existingAnggota = Anggota::where('nis', $request->nisn)->first();
        
        if ($existingAnggota) {
            // Jika sudah ada (didaftarkan admin sblmnya tp belum punya user), hubungkan
            if (!$existingAnggota->user_id) {
                $existingAnggota->update(['user_id' => $user->id]);
            }
        } else {
            // Jika belum ada, buat record Anggota baru
            Anggota::create([
                'user_id' => $user->id,
                'nis' => $request->nisn,
                'nama' => $request->name,
                'kelas' => $request->kelas,
            ]);
        }

        // JANGAN kirim email verifikasi sekarang (tunggu admin approve)
        // event(new Registered($user));

        // JANGAN otomatis login
        // Auth::login($user);

        // Redirect ke login dengan pesan
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda sedang diverifikasi oleh admin. Anda akan menerima email untuk verifikasi setelah akun disetujui.');
    }
}
