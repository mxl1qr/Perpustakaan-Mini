<x-guest-layout>
    <!-- Badge -->
    <p class="login-badge">> Lupa Password</p>

    <!-- Title -->
    <h1 class="login-title">Reset Password</h1>
    <p class="login-subtitle">SMKN 40 Jakarta</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            {{ session('status') }}
        </div>
    @endif

    <p style="font-size: 13px; color: #64748b; margin-bottom: 24px; line-height: 1.6;">
        Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mereset password Anda.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
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

        <!-- Submit Button -->
        <button type="submit" class="btn-login" id="reset-submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
            Kirim Tautan Reset
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
