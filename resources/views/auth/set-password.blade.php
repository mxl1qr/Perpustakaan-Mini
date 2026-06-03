<x-guest-layout>
    <!-- Badge -->
    <p class="login-badge">> Akun Baru</p>

    <!-- Title -->
    <h1 class="login-title">Selamat Datang!</h1>
    <p class="login-subtitle">SMKN 40 Jakarta</p>

    <!-- Info box -->
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 16px; margin-bottom: 24px; display: flex; gap: 10px; align-items: flex-start;">
        <svg style="width:18px;height:18px;color:#16a34a;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p style="font-size: 13px; color: #15803d; margin: 0; line-height: 1.6;">
            Akun Anda telah dibuat oleh Admin. Silakan buat password untuk mulai menggunakan portal perpustakaan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                class="form-input"
                placeholder="contoh@email.com"
                required
                autofocus
                autocomplete="username"
                style="background: #f8fafc; color: #64748b;"
                readonly
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Buat Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="Min. 8 karakter"
                required
                autocomplete="new-password"
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-input"
                placeholder="Ulangi password Anda"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login" id="set-password-submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
            Aktivasi Akun
        </button>
    </form>

    <!-- Bottom -->
    <div class="login-bottom">
        <span class="version-tag">v1.0.0</span>
        <span class="register-text">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="register-link">Login di sini</a>
        </span>
    </div>
</x-guest-layout>
