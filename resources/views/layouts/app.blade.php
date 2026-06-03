<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - Admin' : 'Admin - ' . config('app.name', 'PerpusMini') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">

    <div class="flex h-screen" x-data="{ sidebarOpen: false }">

        {{-- ═══════════════════════════════════════
        OVERLAY MOBILE
        ═══════════════════════════════════════ --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black/50 lg:hidden" style="display:none"></div>

        {{-- ═══════════════════════════════════════
        SIDEBAR
        ═══════════════════════════════════════ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-100 flex flex-col
                  transform transition-transform duration-200 ease-in-out
                  lg:translate-x-0 lg:static lg:z-auto">

            {{-- Logo --}}
            <div class="px-5 py-5 border-b border-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br rounded-xl flex items-center justify-center shadow-sm border border-gray-200">
                        <img src="{{ asset('favicon.png') }}" alt="" class="w-full h-full rounded-xl">
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm leading-tight">Perpustakaan 40</p>
                        <p class="text-xs text-gray-400">Panel Admin</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
                <p class="text-xs text-gray-400 uppercase tracking-widest px-3 pb-3 font-semibold">Navigasi</p>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                {{-- Daftar Koleksi / Buku --}}
                <a href="{{ route('buku.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('buku.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Daftar Koleksi
                </a>

                {{-- Kategori --}}
                <a href="{{ route('kategori.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('kategori.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Kategori Buku
                </a>

                {{-- Anggota --}}
                <a href="{{ route('anggota.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('anggota.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Anggota
                </a>

                {{-- Peminjaman --}}
                <a href="{{ route('peminjaman.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('peminjaman.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Transaksi Pinjam
                </a>

                {{-- Denda --}}
                <a href="{{ route('denda.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('denda.*') ? 'bg-amber-50 text-amber-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Denda
                </a>

                {{-- Laporan --}}
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('laporan.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan
                </a>

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-widest px-3 pb-3 font-semibold">Akun</p>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800 transition">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>
                </div>
            </nav>

            {{-- User card at bottom --}}
            @auth
                <div class="border-t border-gray-100 p-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Logout"
                                class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </aside>

        {{-- ═══════════════════════════════════════
        MAIN AREA
        ═══════════════════════════════════════ --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-100 px-4 sm:px-6 py-3 flex items-center gap-3 shrink-0">
                {{-- Hamburger (mobile only) --}}
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Page heading slot --}}
                <div class="flex-1">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>

                {{-- 🔔 Notification Bell --}}
                <div x-data="notifBell()" class="relative" @click.outside="open = false">
                    <button @click="open = !open"
                            class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="count > 0" x-text="count > 9 ? '9+' : count"
                              class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full px-1 leading-none"
                              style="display:none;"></span>
                    </button>

                    {{-- Dropdown panel --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         style="display:none;"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-800">Pengajuan Peminjaman</h3>
                            <span x-show="count > 0"
                                  class="text-xs bg-amber-100 text-amber-700 font-semibold px-2 py-0.5 rounded-full"
                                  x-text="count + ' menunggu'"></span>
                        </div>
                        <template x-if="items.length === 0">
                            <div class="px-4 py-8 text-center">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm text-gray-400">Tidak ada pengajuan baru</p>
                            </div>
                        </template>
                        <ul class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                            <template x-for="item in items" :key="item.id">
                                <li class="px-4 py-3 hover:bg-amber-50/60 transition cursor-pointer"
                                    @click="window.location.href = item.url">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 truncate" x-text="item.anggota"></p>
                                            <p class="text-xs text-gray-500 truncate" x-text="'📖 ' + item.buku"></p>
                                            <p class="text-xs text-amber-600 mt-0.5" x-text="item.waktu"></p>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                        <div x-show="count > 0" class="px-4 py-2.5 border-t border-gray-100">
                            <a href="{{ route('peminjaman.index') }}"
                               class="block text-center text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                                Lihat semua pengajuan →
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Scrollable content --}}
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>

        </div>
    </div>

    @stack('scripts')

    {{-- ═══ GLOBAL: Custom Confirm Modal ═══ --}}
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
            <div class="w-14 h-14 rounded-full flex items-center justify-center mb-4"
                 :class="iconBg">
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
    // ─── Custom Confirm Modal Logic ───────────────────────────────────────────
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
                this.btnIcon  = detail.btnIcon  || '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
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

    // Global helper – panggil: await askConfirm({ title, message, btnText, ... })
    window.askConfirm = function(options) {
        return new Promise(resolve => {
            window.dispatchEvent(new CustomEvent('confirm-modal', {
                detail: { ...options, resolve }
            }));
        });
    };

    // Intercept semua form yang punya data-confirm
    document.addEventListener('submit', async function(e) {
        const form = e.target;
        const title   = form.dataset.confirmTitle;
        const message = form.dataset.confirm;
        if (!message) return;
        e.preventDefault();
        const ok = await window.askConfirm({
            title:    title || 'Konfirmasi',
            message:  message,
            btnText:  form.dataset.confirmBtn   || 'Ya, Lanjutkan',
            btnClass: form.dataset.confirmClass || 'bg-red-500 hover:bg-red-600',
            btnIcon:  form.dataset.confirmIcon  || '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        });
        if (ok) form.submit();
    }, true);

    // ─── Notification Bell Polling ────────────────────────────────────────────
    function notifBell() {
        return {
            open: false,
            count: 0,
            items: [],
            prevCount: 0,
            init() {
                this.fetchNotif();
                setInterval(() => this.fetchNotif(), 7000); // poll tiap 7 detik
            },
            fetchNotif() {
                fetch('{{ route('notifications.pending') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(data => {
                    // Notif masuk baru → animasi ring
                    if (data.count > this.prevCount && this.prevCount !== null) {
                        this.$el.querySelector('button').classList.add('animate-bounce');
                        setTimeout(() => this.$el.querySelector('button').classList.remove('animate-bounce'), 1500);
                    }
                    this.prevCount = this.count;
                    this.count = data.count;
                    this.items = data.items;
                })
                .catch(() => {});
            }
        };
    }
    </script>
</body>

</html>