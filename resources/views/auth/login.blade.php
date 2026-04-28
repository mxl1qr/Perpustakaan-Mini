<x-guest-layout>
    <!-- Badge -->
    <p class="login-badge">> Login PerpusMini</p>

    <!-- Title -->
    <h1 class="login-title">Selamat Datang</h1>
    <p class="login-subtitle">SMKN 40 Jakarta</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email / Username -->
        <div class="form-group">
            <label for="email" class="form-label">NIS / Username</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-input"
                placeholder="Masukkan NIS kamu"
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
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Forgot Password -->
        <div class="form-footer">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login" id="login-submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
            Masuk
        </button>
    </form>

    <!-- Bottom -->
    <div class="login-bottom">
        <span class="version-tag">v1.0.0</span>
        <span class="register-text">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="register-link">Daftar di sini</a>
        </span>
    </div>
</x-guest-layout>
