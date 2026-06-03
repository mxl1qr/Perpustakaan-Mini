<x-guest-layout>
    <!-- Badge -->
    <p class="login-badge">> Buat Password Baru</p>

    <!-- Title -->
    <h1 class="login-title">Password Baru</h1>
    <p class="login-subtitle">SMKN 40 Jakarta</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
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
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password Baru</label>
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
                placeholder="Ulangi password baru"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login" id="new-password-submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
            Simpan Password
        </button>
    </form>

    <!-- Bottom -->
    <div class="login-bottom">
        <span class="version-tag">v1.0.0</span>
        <span class="register-text">
            Ingat password?
            <a href="{{ route('login') }}" class="register-link">Kembali login</a>
        </span>
    </div>
</x-guest-layout>
