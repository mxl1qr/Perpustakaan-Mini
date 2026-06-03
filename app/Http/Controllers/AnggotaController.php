<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $totalAnggota = Anggota::count();
        $anggotaBaru  = Anggota::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();

        // ── Search (sambungkan ke DB) ──────────────────────────────────────
        $search   = $request->input('search');
        $anggotas = Anggota::when($search, function ($q) use ($search) {
                        $q->where('nama',  'like', "%{$search}%")
                          ->orWhere('nis',   'like', "%{$search}%")
                          ->orWhere('kelas', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->get();

        return view('anggota.index', compact('anggotas', 'totalAnggota', 'anggotaBaru', 'search'));
    }

    public function store(Request $request)
    {
        $role = $request->input('role', 'anggota');

        // Validasi berbeda tergantung role
        $rules = [
            'nama'   => 'required|string|max:100',
            'email'  => 'required|string|lowercase|email|max:255|unique:users,email',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role'   => 'required|in:anggota,admin',
        ];

        if ($role === 'anggota') {
            $rules['nis']   = 'required|string|max:20|unique:anggotas,nis';
            $rules['kelas'] = 'required|string|max:20';
        }

        $request->validate($rules);

        // Buat User
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make(Str::random(24)), // password acak sementara
            'role'     => $role,
            'nisn'     => $role === 'anggota' ? $request->nis : null,
        ]);

        // Paksa set email_verified_at (sudah diverifikasi admin) — bypass fillable
        $user->forceFill(['email_verified_at' => now()])->save();

        // Buat record Anggota hanya jika role = anggota
        if ($role === 'anggota') {
            Anggota::create([
                'user_id' => $user->id,
                'nis'     => $request->nis,
                'nama'    => $request->nama,
                'kelas'   => $request->kelas,
                'no_hp'   => $request->no_hp,
                'alamat'  => $request->alamat,
            ]);
        }

        // Kirim email undangan "Buat Password"
        $this->sendWelcomeEmail($user);

        $label = $role === 'admin' ? 'Admin' : 'Anggota';
        return redirect()->route('anggota.index')
            ->with('success', "{$label} berhasil ditambahkan dan email undangan telah dikirim ke {$user->email}.");
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nis'    => 'required|string|max:20|unique:anggotas,nis,' . $anggota->id,
            'nama'   => 'required|string|max:100',
            'kelas'  => 'required|string|max:20',
            'email'  => 'required|string|lowercase|email|max:255|unique:users,email,' . ($anggota->user_id ?? 'NULL'),
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $anggota->update([
            'nis'    => $request->nis,
            'nama'   => $request->nama,
            'kelas'  => $request->kelas,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        if ($anggota->user) {
            $anggota->user->update([
                'name'  => $request->nama,
                'email' => $request->email,
                'nisn'  => $request->nis,
            ]);
        }

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Anggota $anggota)
    {
        // Hapus akun User terhubung (hard delete) agar anggota tidak bisa login lagi
        if ($anggota->user) {
            $anggota->user->delete();
        }

        // Soft delete anggota — data tetap ada di DB, riwayat peminjaman tidak terhapus
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus. Riwayat peminjaman tetap tersimpan.');
    }

    /**
     * Resend "Set Password" welcome email ke anggota yang belum set password.
     */
    public function resendWelcome(Anggota $anggota)
    {
        $user = $anggota->user;

        if (! $user) {
            return redirect()->route('anggota.index')
                ->with('error', 'Anggota ini tidak memiliki akun user yang terhubung.');
        }

        $this->sendWelcomeEmail($user);

        return redirect()->route('anggota.index')
            ->with('success', "Email undangan berhasil dikirim ulang ke {$user->email}.");
    }

    /**
     * Helper: kirim WelcomeMemberNotification.
     */
    private function sendWelcomeEmail(User $user): void
    {
        $token = app('auth.password.broker')->createToken($user);
        $user->notify(new \App\Notifications\WelcomeMemberNotification(
            token: $token,
            email: $user->email,
            nama:  $user->name,
            nis:   $user->nisn ?? '-',
        ));
    }

    /**
     * Verifikasi pendaftaran anggota mandiri
     */
    public function verify(Anggota $anggota)
    {
        $user = $anggota->user;

        if (!$user) {
            return redirect()->route('anggota.index')
                ->with('error', 'Gagal memverifikasi: Anggota tidak memiliki akun user.');
        }

        if ($user->admin_verified_at) {
            return redirect()->route('anggota.index')
                ->with('info', 'Anggota ini sudah diverifikasi sebelumnya.');
        }

        $user->admin_verified_at = now();
        $user->save();

        // Kirim email verifikasi bawaan (Registered event)
        event(new \Illuminate\Auth\Events\Registered($user));

        return redirect()->route('anggota.index')
            ->with('success', "Anggota {$user->name} berhasil diverifikasi. Email verifikasi telah dikirim otomatis.");
    }
}
