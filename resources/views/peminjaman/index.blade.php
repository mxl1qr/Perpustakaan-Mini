<x-app-layout>
    <x-slot name="title">Transaksi</x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-xl text-gray-800">Transaksi Peminjaman</h2>
                <p class="text-xs text-gray-400 mt-0.5">Kelola semua peminjaman dan pengembalian buku</p>
            </div>
            <button @click="$dispatch('open-pinjam')"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Catat Peminjaman
            </button>
        </div>
    </x-slot>

    <div x-data="{ showModalPinjam: false, activeTab: 'semua' }" class="bg-slate-50 min-h-screen p-4 sm:p-6 relative">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                class="mb-4 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Summary Cards --}}
        @php
            $semuaTotal = $peminjamans->count();
            $aktifTotal = $peminjamans->where('status', 'dipinjam')->count();
            $kembaliTotal = $peminjamans->where('status', 'dikembalikan')->count();
            $lambatTotal = $peminjamans->where('status', 'terlambat')->count();
            $pendingTotal = $peminjamans->where('status', 'diajukan')->count();
            $totalDendaTx = $peminjamans->sum('denda');
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 mb-5">
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-slate-800">{{ $semuaTotal }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Semua Transaksi</p>
            </div>
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-amber-500">{{ $pendingTotal }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Menunggu Validasi</p>
            </div>
            <div class="bg-white rounded-xl border border-blue-100 shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $aktifTotal }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Sedang Dipinjam</p>
            </div>
            <div class="bg-white rounded-xl border border-green-100 shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $kembaliTotal }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Dikembalikan</p>
            </div>
            <div class="bg-white rounded-xl border border-red-100 shadow-sm p-4 text-center">
                <p class="text-2xl font-bold text-red-500">{{ $lambatTotal }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Terlambat</p>
            </div>
            <div class="bg-white rounded-xl border border-rose-100 shadow-sm p-4 text-center col-span-2 sm:col-span-1">
                <p class="text-xl font-bold text-rose-600">Rp {{ number_format($totalDendaTx, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total Denda</p>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">

            {{-- Tab Header --}}
            <div class="flex items-center gap-0 border-b border-slate-100 overflow-x-auto">
                <button @click="activeTab = 'semua'"
                    :class="activeTab === 'semua' ? 'border-b-2 border-blue-600 text-blue-700 font-semibold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-5 py-3.5 text-sm whitespace-nowrap transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Semua
                    <span
                        class="bg-slate-100 text-slate-600 text-xs px-1.5 py-0.5 rounded-full">{{ $semuaTotal }}</span>
                </button>
                <button @click="activeTab = 'diajukan'"
                    :class="activeTab === 'diajukan' ? 'border-b-2 border-amber-500 text-amber-600 font-semibold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-5 py-3.5 text-sm whitespace-nowrap transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Menunggu Validasi
                    @if($pendingTotal > 0)
                        <span class="bg-amber-100 text-amber-700 text-xs px-1.5 py-0.5 rounded-full animate-pulse">{{ $pendingTotal }}</span>
                    @endif
                </button>
                <button @click="activeTab = 'dipinjam'"
                    :class="activeTab === 'dipinjam' ? 'border-b-2 border-blue-600 text-blue-700 font-semibold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-5 py-3.5 text-sm whitespace-nowrap transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Dipinjam
                    <span class="bg-blue-100 text-blue-700 text-xs px-1.5 py-0.5 rounded-full">{{ $aktifTotal }}</span>
                </button>
                <button @click="activeTab = 'dikembalikan'"
                    :class="activeTab === 'dikembalikan' ? 'border-b-2 border-green-600 text-green-700 font-semibold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-5 py-3.5 text-sm whitespace-nowrap transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Dikembalikan
                    <span
                        class="bg-green-100 text-green-700 text-xs px-1.5 py-0.5 rounded-full">{{ $kembaliTotal }}</span>
                </button>
                <button @click="activeTab = 'terlambat'"
                    :class="activeTab === 'terlambat' ? 'border-b-2 border-red-500 text-red-600 font-semibold' : 'text-slate-500 hover:text-slate-700'"
                    class="px-5 py-3.5 text-sm whitespace-nowrap transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Terlambat
                    @if($lambatTotal > 0)
                        <span class="bg-red-100 text-red-700 text-xs px-1.5 py-0.5 rounded-full">{{ $lambatTotal }}</span>
                    @endif
                </button>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide border-b border-slate-100">
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Anggota</th>
                            <th class="px-4 py-3 text-left">Buku</th>
                            <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-center">Tgl Kembali</th>
                            <th class="px-4 py-3 text-center">Tgl Dikembalikan</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Denda</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php $no = 1; @endphp
                        @forelse ($peminjamans as $p)
                            <tr x-show="activeTab === 'semua' || activeTab === '{{ $p->status }}'"
                                class="hover:bg-slate-50/70 transition">
                                <td class="px-4 py-3.5 text-slate-400 text-xs">{{ $no++ }}</td>
                                <td class="px-4 py-3.5">
                                    <p class="font-medium text-slate-800">{{ $p->anggota->nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $p->anggota->nis }}</p>
                                </td>
                                <td class="px-4 py-3.5">
                                    <p class="text-slate-700 font-medium">{{ $p->buku->judul }}</p>
                                    <p class="text-xs text-slate-400">{{ $p->buku->pengarang }}</p>
                                </td>
                                <td class="px-4 py-3.5 text-center text-slate-500 text-xs">
                                    {{ $p->tgl_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3.5 text-center text-xs">
                                    <span
                                        class="{{ now()->gt($p->tgl_kembali_rencana) && $p->status === 'dipinjam' ? 'text-red-500 font-semibold' : 'text-slate-500' }}">
                                        {{ $p->tgl_kembali_rencana->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center text-slate-500 text-xs">
                                    {{ $p->tgl_kembali_aktual ? $p->tgl_kembali_aktual->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if($p->status === 'diajukan')
                                        <span
                                            class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full font-medium">Menunggu Validasi</span>
                                    @elseif($p->status === 'dipinjam')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">Dipinjam</span>
                                    @elseif($p->status === 'dikembalikan')
                                        <span
                                            class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">Dikembalikan</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">Terlambat</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    @if($p->denda > 0)
                                        <span class="text-red-600 font-semibold text-xs">Rp
                                            {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    @if($p->status === 'diajukan')
                                        <div class="flex items-center gap-1.5 justify-center">
                                            <form action="{{ route('peminjaman.setujui', $p->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-emerald-500 text-white px-2.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-600 transition shadow-sm">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST" class="inline"
                                                  data-confirm="Tolak permintaan peminjaman buku '{{ $p->buku->judul }}' dari {{ $p->anggota->nama }}?"
                                                  data-confirm-title="Tolak Peminjaman?"
                                                  data-confirm-btn="Ya, Tolak"
                                                  data-confirm-class="bg-rose-500 hover:bg-rose-600">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-500 text-white px-2.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-rose-600 transition shadow-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($p->status === 'dipinjam')
                                        <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST"
                                            class="inline"
                                            data-confirm="Konfirmasi pengembalian buku '{{ $p->buku->judul }}' dari {{ $p->anggota->nama }}?"
                                            data-confirm-title="Kembalikan Buku?"
                                            data-confirm-btn="Ya, Kembalikan"
                                            data-confirm-class="bg-green-600 hover:bg-green-700"
                                            data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'>
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-green-900 transition">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-450">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-slate-400">Belum ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="sm:hidden p-3 space-y-2">
                @forelse ($peminjamans as $p)
                    <div x-show="activeTab === 'semua' || activeTab === '{{ $p->status }}'"
                        class="border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-sm text-slate-800">{{ $p->anggota->nama }}</p>
                                <p class="text-xs text-slate-400">{{ $p->anggota->nis }}</p>
                            </div>
                            @if($p->status === 'diajukan')
                                <span
                                    class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full font-medium">Validasi</span>
                            @elseif($p->status === 'dipinjam')
                                <span
                                    class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">Dipinjam</span>
                            @elseif($p->status === 'dikembalikan')
                                <span
                                    class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Kembali</span>
                            @else
                                <span
                                    class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">Terlambat</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-700 font-medium mb-1">📖 {{ $p->buku->judul }}</p>
                        <p class="text-xs text-slate-500">📅 {{ $p->tgl_pinjam->format('d/m/Y') }} →
                            {{ $p->tgl_kembali_rencana->format('d/m/Y') }}</p>
                        @if($p->tgl_kembali_aktual)
                            <p class="text-xs text-green-600 mt-0.5">✅ Dikembalikan:
                                {{ $p->tgl_kembali_aktual->format('d/m/Y') }}</p>
                        @endif
                        @if($p->denda > 0)
                            <p class="text-xs text-red-600 mt-0.5 font-semibold">💰 Denda: Rp
                                {{ number_format($p->denda, 0, ',', '.') }}</p>
                        @endif
                        @if($p->status === 'diajukan')
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <form action="{{ route('peminjaman.setujui', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 text-white py-2 rounded-lg text-xs font-semibold hover:bg-emerald-600 transition text-center shadow-sm">
                                        ✓ Setujui
                                    </button>
                                </form>
                                <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST"
                                      data-confirm="Tolak permintaan peminjaman buku '{{ $p->buku->judul }}' dari {{ $p->anggota->nama }}?"
                                      data-confirm-title="Tolak Peminjaman?"
                                      data-confirm-btn="Ya, Tolak"
                                      data-confirm-class="bg-rose-500 hover:bg-rose-600">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-rose-500 text-white py-2 rounded-lg text-xs font-semibold hover:bg-rose-600 transition text-center shadow-sm">
                                        ✗ Tolak
                                    </button>
                                </form>
                            </div>
                        @elseif($p->status === 'dipinjam')
                            <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="mt-3"
                                  data-confirm="Konfirmasi pengembalian buku '{{ $p->buku->judul }}'?"
                                  data-confirm-title="Kembalikan Buku?"
                                  data-confirm-btn="Ya, Kembalikan"
                                  data-confirm-class="bg-green-600 hover:bg-green-700"
                                  data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'>
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-500 text-white py-2 rounded-lg text-xs font-semibold hover:bg-green-600 transition">
                                    ✓ Kembalikan Buku
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400 text-sm">Belum ada data transaksi.</div>
                @endforelse
            </div>

        </div>


    {{-- MODAL PINJAM --}}
    <div x-show="showModalPinjam" @open-pinjam.window="showModalPinjam = true" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModalPinjam" @click="showModalPinjam = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showModalPinjam" x-transition.scale.origin.bottom class="inline-block w-full max-w-md px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Catat Peminjaman
                    </h3>
                    <button @click="showModalPinjam = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Anggota Peminjam <span class="text-red-500">*</span></label>
                            <select name="anggota_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}">{{ $anggota->nama }} - {{ $anggota->nis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Buku yang Dipinjam <span class="text-red-500">*</span></label>
                            <select name="buku_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                <option value="">-- Pilih Buku --</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id }}">{{ $buku->judul }} (Sisa Stok: {{ $buku->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tgl Kembali Rencana <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_kembali_rencana" value="{{ now()->addDays(14)->format('Y-m-d') }}" max="{{ now()->addDays(14)->format('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModalPinjam = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>