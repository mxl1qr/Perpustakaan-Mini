<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - Perpustakaan SMKN 40' : 'Portal Siswa - Perpustakaan SMKN 40' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Secara default semua teks menggunakan Inter */
        body {
            font-family: 'Inter', sans-serif !important;
        }
        /* Judul besar & headline menggunakan Plus Jakarta Sans */
        h1, h2, h3, h4, h5, h6, .font-headline {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        /* Label, tombol, dan badge menggunakan Plus Jakarta Sans */
        button, label, .badge, .font-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body.portal-bg {
            /* Warm gradient: putih hangat → krem → oranye lembut — gaya Anthropic */
            background: radial-gradient(ellipse 120% 80% at 80% -10%, #ff8c5520 0%, transparent 60%),
                        radial-gradient(ellipse 80% 60% at 0% 100%, #ffb74d18 0%, transparent 55%),
                        linear-gradient(160deg, #fffbf7 0%, #fff8f0 35%, #fff1e4 65%, #fde9d4 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        .portal-navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(16px) saturate(1.5);
            -webkit-backdrop-filter: blur(16px) saturate(1.5);
            border-bottom: 1.5px solid rgba(148, 163, 184, 0.35) !important;
        }
        .portal-footer {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-top: 1.5px solid rgba(148, 163, 184, 0.35);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 portal-bg">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navbar -->
        <nav class="portal-navbar sticky top-0 z-50" x-data="{ mobileOpen: false, profileOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 relative">

                    <!-- Kiri: Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('anggota.portal') }}" class="flex items-center gap-2.5">
                            <div class="w-8 h-8 flex items-center justify-center">
                                <img src="{{ asset('favicon.png') }}" alt="Logo">
                            </div>
                            <span class="font-bold text-base tracking-tight text-slate-900 hidden sm:block">Forty Libs</span>
                        </a>
                    </div>

                    <!-- Tengah: Nav Links (Desktop only, absolute center) -->
                    <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 h-full items-center gap-1">
                        @foreach([
                            ['route' => 'anggota.portal',    'label' => 'Beranda'],
                            ['route' => 'anggota.katalog',   'label' => 'Koleksi'],
                            ['route' => 'anggota.favorit',   'label' => 'Favorit'],
                            ['route' => 'anggota.keranjang', 'label' => 'Keranjang'],
                            ['route' => 'anggota.transaksi', 'label' => 'Transaksi'],
                        ] as $nav)
                            <a href="{{ route($nav['route']) }}"
                               class="px-3 py-1.5 rounded-lg text-sm font-semibold transition-all duration-150 flex items-center gap-1.5
                                      {{ request()->routeIs($nav['route'])
                                         ? 'bg-blue-50 text-blue-600'
                                         : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100/70' }}">
                                {{ $nav['label'] }}
                                @if($nav['route'] === 'anggota.keranjang')
                                    @php
                                        $cartCount = count(session()->get('cart', []));
                                    @endphp
                                    @if($cartCount > 0)
                                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded-full">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <!-- Kanan: Profil (Desktop) + Hamburger (Mobile) -->
                    <div class="flex items-center gap-2">
                        <!-- Profile dropdown (Desktop) -->
                        <div class="hidden sm:block relative" @click.outside="profileOpen = false">
                            <button @click="profileOpen = !profileOpen"
                                    class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 focus:outline-none transition-colors px-2 py-1.5 rounded-lg hover:bg-slate-100/70">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="hidden lg:block max-w-[100px] truncate">{{ Auth::user()->name ?? 'Anggota' }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 style="display:none;"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200/80 py-1 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akun</p>
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name ?? 'Anggota' }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Profil Akun
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-rose-500 hover:bg-rose-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Hamburger (Mobile only) -->
                        <button @click="mobileOpen = !mobileOpen"
                                class="sm:hidden p-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition focus:outline-none">
                            <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileOpen" style="display:none;" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                 style="display:none;"
                 class="sm:hidden border-t border-slate-200/60 bg-white/95 backdrop-blur-lg">
                <div class="px-4 pt-3 pb-4 space-y-1">
                    @foreach([
                        ['route' => 'anggota.portal',    'label' => 'Beranda',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'anggota.katalog',   'label' => 'Daftar Koleksi','icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['route' => 'anggota.favorit',   'label' => 'Buku Favorit',  'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                        ['route' => 'anggota.keranjang', 'label' => 'Keranjang',     'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['route' => 'anggota.transaksi', 'label' => 'Transaksi',     'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ] as $nav)
                        <a href="{{ route($nav['route']) }}" @click="mobileOpen = false"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition
                                  {{ request()->routeIs($nav['route'])
                                     ? 'bg-blue-50 text-blue-600'
                                     : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $nav['icon'] }}"/>
                                </svg>
                                {{ $nav['label'] }}
                            </div>
                            @if($nav['route'] === 'anggota.keranjang')
                                @php
                                    $cartCount = count(session()->get('cart', []));
                                @endphp
                                @if($cartCount > 0)
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded-full">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            @endif
                        </a>
                    @endforeach

                    <div class="border-t border-slate-100 pt-3 mt-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Akun
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-semibold text-rose-500 hover:bg-rose-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
            @endif

            {{ $slot }}
        </main>
        
        <footer class="portal-footer mt-auto py-6 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} Portal Siswa &mdash; PerpusMini SMKN 40 Jakarta.
        </footer>
    </div>

    {{-- ═══ GLOBAL: Custom Confirm Modal (Member) ═══ --}}
    <div id="customConfirmModal"
         class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         style="display:none !important;"
         x-data="confirmModal()"
         @confirm-modal.window="handleOpen($event.detail)">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="cancel()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 flex flex-col items-center text-center"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="w-14 h-14 rounded-full flex items-center justify-center mb-4" :class="iconBg">
                <svg class="w-7 h-7" :class="iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="iconPath"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1" x-text="title"></h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-6" x-text="message"></p>
            <div class="flex gap-3 w-full">
                <button @click="cancel()"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Batal
                </button>
                <button @click="confirm()"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition flex items-center justify-center gap-2"
                        :class="btnClass">
                    <span x-html="btnIcon"></span>
                    <span x-text="btnText"></span>
                </button>
            </div>
        </div>
    </div>

    <script>
    function confirmModal() {
        return {
            title: '', message: '', btnText: 'Ya', btnClass: 'bg-red-500 hover:bg-red-600',
            btnIcon: '', iconBg: 'bg-red-100', iconColor: 'text-red-500',
            iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            _resolve: null,
            handleOpen(detail) {
                this.title    = detail.title   || 'Konfirmasi';
                this.message  = detail.message || 'Apakah Anda yakin?';
                this.btnText  = detail.btnText || 'Ya';
                this.btnClass = detail.btnClass || 'bg-red-500 hover:bg-red-600';
                this.btnIcon  = detail.btnIcon  || '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                this.iconBg   = detail.iconBg  || 'bg-red-100';
                this.iconColor= detail.iconColor|| 'text-red-500';
                this.iconPath = detail.iconPath || 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
                this._resolve = detail.resolve;
                document.getElementById('customConfirmModal').style.removeProperty('display');
                document.getElementById('customConfirmModal').style.display = 'flex';
            },
            confirm() {
                document.getElementById('customConfirmModal').style.display = 'none';
                if (this._resolve) this._resolve(true);
            },
            cancel() {
                document.getElementById('customConfirmModal').style.display = 'none';
                if (this._resolve) this._resolve(false);
            }
        };
    }
    window.askConfirm = function(options) {
        return new Promise(resolve => {
            window.dispatchEvent(new CustomEvent('confirm-modal', { detail: { ...options, resolve } }));
        });
    };
    document.addEventListener('submit', async function(e) {
        const form = e.target;
        const message = form.dataset.confirm;
        if (!message) return;
        e.preventDefault();
        const ok = await window.askConfirm({
            title:    form.dataset.confirmTitle || 'Konfirmasi',
            message:  message,
            btnText:  form.dataset.confirmBtn   || 'Ya, Lanjutkan',
            btnClass: form.dataset.confirmClass || 'bg-red-500 hover:bg-red-600',
            btnIcon:  form.dataset.confirmIcon  || '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        });
        if (ok) form.submit();
    }, true);
    </script>
</body>
</html>

