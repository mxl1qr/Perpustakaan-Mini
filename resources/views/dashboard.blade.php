<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-xl text-gray-800">Dashboard</h2>
                <p class="text-xs text-gray-400 mt-0.5" id="live-clock"></p>
            </div>
            {{-- <button @click="$dispatch('open-pinjam')"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Peminjaman Baru
            </button> --}}
        </div>
    </x-slot>

    <div x-data="{ showModalBuku: false, showModalAnggota: false, showModalPinjam: false, showModalKembali: false, selectedKembaliUrl: '' }"
        @open-pinjam.window="showModalPinjam = true" class="bg-slate-50 min-h-screen relative p-4 sm:p-6 space-y-6">

        {{-- ═══ HERO BANNER ═══ --}}
        <div
            class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-900 rounded-2xl p-6 relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-slate-400 text-sm">Selamat datang kembali 👋</p>
                <h1 class="text-white font-bold text-2xl mt-0.5">{{ Auth::user()->name }}</h1>
                <p class="text-slate-400 text-xs mt-1">Berikut ringkasan aktivitas Perpustakaan hari ini.</p>
            </div>
            <div class="flex gap-6 sm:text-right relative z-10">
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-wide">Dipinjam Aktif</p>
                    <p class="text-white font-bold text-3xl">{{ $dipinjam }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-wide">Denda Bulan Ini</p>
                    <p class="text-yellow-400 font-bold text-2xl">Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-6">

            {{-- ═══ ROW 1: STAT CARDS + CHART ═══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

                {{-- Stat Cards (2 × 2) --}}
                <div class="lg:col-span-2 grid grid-cols-2 gap-4">

                    {{-- Total Buku --}}
                    <div
                        class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Total Koleksi Buku</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $totalBuku }}</p>
                        </div>
                    </div>

                    {{-- Total Anggota --}}
                    <div
                        class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Total Anggota Aktif
                            </p>
                            <p class="text-2xl font-bold text-slate-800">{{ $totalAnggota }}</p>
                        </div>
                    </div>

                    {{-- Buku Dipinjam --}}
                    <div
                        class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Buku Dipinjam (Aktif)
                            </p>
                            <p class="text-2xl font-bold text-slate-800">{{ $dipinjam }}</p>
                        </div>
                    </div>

                    {{-- Terlambat --}}
                    <div
                        class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col gap-3 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Terlambat Dikembalikan
                            </p>
                            <p class="text-2xl font-bold text-slate-800">{{ $jumlahTerlambat }}</p>
                        </div>
                    </div>
                </div>

                {{-- Chart Statistik Bulanan --}}
                <div class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-slate-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-800">Statistik Peminjaman Bulanan</h3>
                            <p class="text-xs text-slate-400">6 bulan terakhir</p>
                        </div>
                        <div class="flex gap-3 text-xs text-slate-500">
                            <span class="flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span> Dipinjam</span>
                            <span class="flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Dikembalikan</span>
                            <span class="flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Terlambat</span>
                        </div>
                    </div>
                    <canvas id="peminjamanChart" height="160"></canvas>
                </div>
            </div>

            {{-- ═══ ROW 2: Peminjaman Terbaru + Info Bar ═══ --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                    <p class="text-xs text-slate-400 mb-1">Peminjaman Bulan Ini</p>
                    <p class="text-xl font-bold text-slate-800">{{ $chartDipinjam[5] ?? 0 }} <span
                            class="text-xs text-slate-400 font-normal">transaksi</span></p>
                    <p class="text-xs text-slate-400 mt-1">Total selama {{ now()->format('M Y') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                    <p class="text-xs text-slate-400 mb-1">Dikembalikan Bulan Ini</p>
                    <p class="text-xl font-bold text-green-600">{{ $chartDikembalikan[5] ?? 0 }} <span
                            class="text-xs text-slate-400 font-normal">buku</span></p>
                    <p class="text-xs text-slate-400 mt-1">Total selama {{ now()->format('M Y') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                    <p class="text-xs text-slate-400 mb-1">Denda Bergulir</p>
                    <p class="text-xl font-bold text-amber-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-400 mt-1">Jatuh tempo {{ now()->format('M Y') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                    <p class="text-xs text-slate-400 mb-1">Buku Populer #1</p>
                    @if($bukuPopuler->isNotEmpty())
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $bukuPopuler->first()->judul }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $bukuPopuler->first()->peminjaman_count }}x dipinjam</p>
                    @else
                        <p class="text-sm text-slate-400">Belum ada data</p>
                    @endif
                </div>
            </div>

            {{-- ═══ ROW 3: Peminjaman Terbaru + Aksi Cepat ═══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- Tabel Peminjaman Terbaru --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-5 py-4 flex items-center justify-between border-b border-slate-100">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-800">Peminjaman Terbaru</h3>
                            <p class=" text-xs text-slate-400">{{ $recentPeminjamans->count() }} transaksi terakhir</p>
                        </div>
                        <a href="{{ route('peminjaman.index') }}"
                            class="text-xs text-blue-600 hover:underline font-medium">Lihat Semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                                    <th class="px-4 py-3 text-left">#</th>
                                    <th class="px-4 py-3 text-left">Nama Anggota</th>
                                    <th class="px-4 py-3 text-left">Judul Buku</th>
                                    <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                                    <th class=" px-4 py-3 text-center">Tgl Kembali</th>
                                    <th class="px-4 py-3 text-center">Status</th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse ($recentPeminjamans as $i => $p)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 text-slate-400">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-slate-800">{{ $p->anggota->nama }}</p>
                                            <p class="text-xs text-slate-400">{{ $p->anggota->nis }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-slate-700 max-w-[160px] truncate">{{ $p->buku->judul }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-slate-500 text-xs">
                                            {{ $p->tgl_pinjam->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-slate-500 text-xs">
                                            {{ $p->tgl_kembali_rencana->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($p->status === 'dipinjam')
                                                <span
                                                    class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">Dipinjam</span>
                                            @elseif($p->status === 'dikembalikan')
                                                <span
                                                    class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium">Dikembalikan</span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full font-medium">Terlambat</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-sm">Belum ada data
                                            peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Aksi Cepat --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class=" px-5 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-semibold text-slate-800">Aksi Cepat</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        <button type="button" @click="showModalBuku = true"
                            class="w-full text-left flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">Tambah Buku Baru</p>
                                <p class="text-xs text-slate-400">Input koleksi buku terbaru</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="button" @click="showModalAnggota = true"
                            class="w-full text-left flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-teal-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">Daftarkan Anggota</p>
                                <p class="text-xs text-slate-400">Tambah data anggota baru</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="button" @click="showModalPinjam = true"
                            class="w-full text-left flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">Catat Peminjaman</p>
                                <p class="text-xs text-slate-400">Input transaksi pinjam buku</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="button" @click="showModalKembali = true"
                            class="w-full text-left flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 transition group">
                            <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">Proses Pengembalian
                                </p>
                                <p class="text-xs text-slate-400">Kembalikan buku yang dipinjam</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ═══ FOOTER ═══ --}}

            {{-- ═══ FOOTER ═══ --}}
            <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 pt-2 pb-4 gap-2">
                <p>© {{ date('Y') }} PerpusMini — SMKN 40 Jakarta. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="{{ route('buku.index') }}" class="hover:text-slate-600 transition">Koleksi Buku</a>
                    <a href="{{ route('anggota.index') }}" class="hover:text-slate-600 transition">Anggota</a>
                    <a href="{{ route('peminjaman.index') }}" class="hover:text-slate-600 transition">Peminjaman</a>
                </div>
            </div>


        </div>

        {{-- ═════ MODALS Aksi Cepat ═════ --}}

        {{-- MODAL BUKU --}}
        <div x-show="showModalBuku" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalBuku" @click="showModalBuku = false" x-transition.opacity
                    class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalBuku" x-transition.scale.origin.bottom
                    class="inline-block w-full max-w-2xl px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Buku Baru
                        </h3>
                        <button @click="showModalBuku = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="judul" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="penulis" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="penerbit" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="tahun_terbit" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Stok <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="stok" value="1" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori <span
                                        class="text-red-500">*</span></label>
                                <select name="kategori_id" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Cover Buku</label>
                                <input type="file" name="cover" accept="image/*"
                                    class="w-full px-3 py-1.5 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalBuku = false"
                                class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL ANGGOTA --}}
        <div x-show="showModalAnggota" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalAnggota" @click="showModalAnggota = false" x-transition.opacity
                    class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalAnggota" x-transition.scale.origin.bottom
                    class="inline-block w-full max-w-lg px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftarkan Anggota
                        </h3>
                        <button @click="showModalAnggota = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('anggota.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Induk Siswa (NIS)
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nis" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="kelas" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP</label>
                                <input type="text" name="no_hp"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat</label>
                                <textarea name="alamat" rows="2"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalAnggota = false"
                                class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL PINJAM --}}
        <div x-show="showModalPinjam" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalPinjam" @click="showModalPinjam = false" x-transition.opacity
                    class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalPinjam" x-transition.scale.origin.bottom
                    class="inline-block w-full max-w-md px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Catat Peminjaman
                        </h3>
                        <button @click="showModalPinjam = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Anggota Peminjam <span
                                        class="text-red-500">*</span></label>
                                <select name="anggota_id" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($anggotas_all as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama }} - {{ $anggota->nis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Buku yang Dipinjam <span
                                        class="text-red-500">*</span></label>
                                <select name="buku_id" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach($bukus_all as $buku)
                                        <option value="{{ $buku->id }}">{{ $buku->judul }} (Sisa Stok: {{ $buku->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tgl Kembali Rencana <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tgl_kembali_rencana"
                                    value="{{ now()->addDays(14)->format('Y-m-d') }}"
                                    max="{{ now()->addDays(14)->format('Y-m-d') }}" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalPinjam = false"
                                class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL KEMBALI --}}
        <div x-show="showModalKembali" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalKembali" @click="showModalKembali = false" x-transition.opacity
                    class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalKembali" x-transition.scale.origin.bottom
                    class="inline-block w-full max-w-md px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Proses Pengembalian
                        </h3>
                        <button @click="showModalKembali = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form :action="selectedKembaliUrl" method="POST" x-ref="kembaliForm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Transaksi Aktif
                                    <span class="text-red-500">*</span></label>
                                <select x-model="selectedKembaliUrl" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Buku yang Dipinjam --</option>
                                    @foreach($peminjamanAktif as $pa)
                                        <option value="{{ route('peminjaman.kembalikan', $pa->id) }}">
                                            {{ $pa->anggota->nama }} - {{ $pa->buku->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalKembali = false"
                                class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm"
                                :disabled="!selectedKembaliUrl"
                                :class="{'opacity-50 cursor-not-allowed': !selectedKembaliUrl}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Proses Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            // Live clock
            function updateClock() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                const el = document.getElementById('live-clock');
                if (el) el.textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
            }
            updateClock();
            setInterval(updateClock, 1000);

            // Chart.js
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Dipinjam',
                            data: @json($chartDipinjam),
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59,130,246,0.08)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Dikembalikan',
                            data: @json($chartDikembalikan),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,0.06)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Terlambat',
                            data: @json($chartTerlambat),
                            borderColor: '#f87171',
                            backgroundColor: 'rgba(248,113,113,0.05)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, color: '#94a3b8', font: { size: 11 } },
                            grid: { color: '#f1f5f9' },
                        },
                        x: {
                            ticks: { color: '#94a3b8', font: { size: 11 } },
                            grid: { display: false },
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>