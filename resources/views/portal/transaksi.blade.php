<x-member-layout>
    <div class="py-6 space-y-8">

        <!-- Page Title -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Transaksi Saya</h2>
                <p class="text-slate-500 mt-1">Pantau riwayat peminjaman dan informasi denda Anda.</p>
            </div>
            <a href="{{ route('anggota.transaksi.cetak') }}" target="_blank" class="inline-flex items-center gap-1.5 bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Riwayat
            </a>
        </div>

        <!-- ── MAIN LAYOUT: 2/3 and 1/3 Split ── -->
        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- ─── KOLOM UTAMA (65%): Ringkasan + Tabel ─── --}}
            <div class="w-full lg:w-2/3 space-y-6">

                <!-- Stat Cards — Redesigned for Symmetry -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach([
                        ['label' => 'Total',     'value' => $stats['total'],    'color' => 'slate',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['label' => 'Diajukan',  'value' => $stats['diajukan'], 'color' => 'amber',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Dipinjam',  'value' => $stats['dipinjam'], 'color' => 'blue',   'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                        ['label' => 'Terlambat', 'value' => $stats['terlambat'],'color' => 'rose',   'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ] as $item)
                        <div class="bg-white rounded-2xl border border-{{ $item['color'] }}-100 shadow-sm p-4 hover:shadow-md transition duration-300">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-8 h-8 rounded-lg bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                                </div>
                                <span class="text-2xl font-extrabold text-{{ $item['color'] }}-600">{{ $item['value'] }}</span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item['label'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Tabel Riwayat -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Daftar Transaksi
                        </h3>
                        <span class="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 px-3 py-1 rounded-full shadow-sm">
                            {{ $riwayat->total() }} Record
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-slate-100">
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Informasi Buku</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Peminjaman</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Denda</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($riwayat as $p)
                                    @php
                                        $isLateActive = $p->status == 'dipinjam' && $p->tgl_kembali_rencana->isPast();
                                        $displayDenda = $p->denda;
                                        if ($isLateActive) {
                                            $displayDenda = now()->diffInDays($p->tgl_kembali_rencana) * 1000;
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-50/80 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-900 text-sm group-hover:text-blue-600 transition-colors">{{ $p->buku->judul ?? 'Buku Dihapus' }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $p->buku->penulis ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-[11px] font-medium text-slate-500">Pinjam: <span class="text-slate-700 font-bold">{{ $p->tgl_pinjam->format('d M Y') }}</span></div>
                                            <div class="text-[11px] font-medium mt-1 {{ $isLateActive ? 'text-rose-500' : 'text-slate-500' }}">
                                                Batas: <span class="font-bold">{{ $p->tgl_kembali_rencana->format('d M Y') }}</span>
                                                @if($isLateActive)
                                                    <span class="ml-1 text-[9px] bg-rose-100 px-1.5 py-0.5 rounded-md font-extrabold">+{{ now()->diffInDays($p->tgl_kembali_rencana) }}h</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-sm font-extrabold {{ $displayDenda > 0 ? 'text-rose-500' : 'text-slate-300' }}">
                                                Rp{{ number_format($displayDenda, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($p->status == 'diajukan')
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">Diajukan</span>
                                            @elseif($isLateActive)
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100 animate-pulse">Terlambat</span>
                                            @elseif($p->status == 'dipinjam')
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">Aktif</span>
                                            @elseif($p->status == 'dikembalikan')
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Kembali</span>
                                            @elseif($p->status == 'terlambat')
                                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">Late Return</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="font-bold text-slate-400">Belum ada riwayat transaksi.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($riwayat->hasPages())
                        <div class="p-4 bg-slate-50/50 border-t border-slate-100">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- ─── KOLOM SAMPING (35%): Info Denda ─── --}}
            <div class="w-full lg:w-1/3 space-y-6">

                <!-- Header Sidebar -->
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1.5 h-5 bg-rose-500 rounded-full"></div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Denda</h3>
                </div>

                <!-- Total Denda Card -->
                <div class="bg-gradient-to-br from-rose-600 to-rose-500 rounded-3xl p-6 text-white shadow-xl shadow-rose-200/50 relative overflow-hidden group">
                    <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white opacity-10 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-bold text-rose-100 uppercase tracking-widest mb-3 opacity-80">Akumulasi Seluruh Denda</p>
                        <p class="text-3xl xl:text-4xl font-extrabold leading-tight tracking-tight truncate">Rp{{ number_format($dendaStats['total'], 0, ',', '.') }}</p>
                        <div class="mt-6 flex items-center justify-between border-t border-white/20 pt-4 gap-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-bold text-rose-100 uppercase opacity-70 mb-1 truncate">Sudah Bayar</p>
                                <p class="text-xs xl:text-sm font-bold truncate">Rp{{ number_format($dendaStats['sudah'], 0, ',', '.') }}</p>
                            </div>
                            <div class="flex-1 min-w-0 text-right">
                                <p class="text-[9px] font-bold text-rose-100 uppercase opacity-70 mb-1 truncate">Tunggakan</p>
                                <p class="text-xs xl:text-sm font-bold text-white truncate">Rp{{ number_format($dendaStats['belum'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rincian Denda per Buku -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h4 class="text-xs font-bold text-slate-700">Rincian per Item</h4>
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <div class="max-h-64 overflow-y-auto">
                        @if($rinciDenda->isNotEmpty())
                            <ul class="divide-y divide-slate-50">
                                @foreach($rinciDenda as $d)
                                    <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-800 text-xs truncate">{{ $d->buku->judul ?? 'Buku Dihapus' }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1 font-medium italic">
                                                    @if($d->status == 'dipinjam')
                                                        Potensi denda aktif
                                                    @else
                                                        Denda keterlambatan
                                                    @endif
                                                </p>
                                            </div>
                                            <span class="text-sm font-extrabold text-rose-500 shrink-0">
                                                Rp{{ number_format($d->denda, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-10 text-center">
                                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-slate-800">Bebas Denda! 🎉</p>
                                <p class="text-[10px] text-slate-400 mt-1">Terima kasih telah disiplin.</p>
                            </div>
                        @endif
                    </div>
                    
                    @if($dendaStats['belum'] > 0)
                        <div class="p-5 bg-amber-50 border-t border-amber-100">
                            <p class="text-[10px] text-amber-700 font-medium leading-relaxed">
                                <strong>Catatan:</strong> Silakan hubungi pustakawan untuk pelunasan denda agar dapat terus menggunakan layanan perpustakaan.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-member-layout>
