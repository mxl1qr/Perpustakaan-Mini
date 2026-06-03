<x-app-layout>
    <x-slot name="title">Denda</x-slot>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Denda & Tunggakan</h2>
            <p class="text-xs text-gray-400 mt-0.5">Rekap denda keterlambatan pengembalian buku</p>
        </div>
    </x-slot>

    <div class="bg-slate-50 min-h-screen p-4 sm:p-6 space-y-5">

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ═══ PENGATURAN DENDA ═══ --}}
        <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden">
            <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-amber-50/50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Pengaturan Denda</h3>
                        <p class="text-xs text-slate-400">Atur tarif, toleransi, dan batas maksimal denda</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-4 text-xs text-slate-500">
                        <span class="bg-amber-50 border border-amber-200 text-amber-700 px-2.5 py-1 rounded-lg font-semibold">
                            Rp {{ number_format($settings['tarif_per_hari']->value ?? 1000, 0, ',', '.') }} / hari
                        </span>
                        <span class="bg-slate-50 border border-slate-200 text-slate-600 px-2.5 py-1 rounded-lg font-semibold">
                            Toleransi {{ $settings['toleransi_hari']->value ?? 0 }} hari
                        </span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div x-show="open" x-transition style="display:none;" class="px-5 pb-5 border-t border-amber-50">
                <form action="{{ route('denda.settings') }}" method="POST" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            {{ $settings['tarif_per_hari']->label ?? 'Tarif per Hari' }}
                        </label>
                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-amber-400">
                            <span class="px-3 py-2 bg-slate-50 text-slate-500 text-sm border-r border-slate-300">Rp</span>
                            <input type="number" name="tarif_per_hari" min="0" value="{{ $settings['tarif_per_hari']->value ?? 1000 }}"
                                   class="flex-1 px-3 py-2 text-sm text-slate-800 bg-white outline-none">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Denda per hari keterlambatan</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            {{ $settings['toleransi_hari']->label ?? 'Toleransi Keterlambatan' }}
                        </label>
                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-amber-400">
                            <input type="number" name="toleransi_hari" min="0" value="{{ $settings['toleransi_hari']->value ?? 0 }}"
                                   class="flex-1 px-3 py-2 text-sm text-slate-800 bg-white outline-none">
                            <span class="px-3 py-2 bg-slate-50 text-slate-500 text-sm border-l border-slate-300">hari</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Isi 0 jika tidak ada toleransi</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Denda Maksimal
                        </label>
                        <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-amber-400">
                            <span class="px-3 py-2 bg-slate-50 text-slate-500 text-sm border-r border-slate-300">Rp</span>
                            <input type="number" name="denda_maksimal" min="0" value="{{ $settings['denda_maksimal']->value ?? 0 }}"
                                   class="flex-1 px-3 py-2 text-sm text-slate-800 bg-white outline-none">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Isi 0 jika tidak ada batas maksimal</p>
                    </div>
                    <div class="sm:col-span-3 flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-red-100 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Denda Belum Lunas</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $dendaAktif->count() }} <span class="text-sm text-slate-400 font-normal">anggota</span></p>
                    <p class="text-sm font-semibold text-red-600 mt-0.5">Rp {{ number_format($totalDendaAktif, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-green-100 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Denda Sudah Lunas</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $dendaLunas->count() }} <span class="text-sm text-slate-400 font-normal">transaksi</span></p>
                    <p class="text-sm font-semibold text-green-600 mt-0.5">Rp {{ number_format($totalDendaLunas, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Total Denda Keseluruhan</p>
                    <p class="text-xl font-bold text-amber-600 mt-1">Rp {{ number_format($totalDendaAll, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Denda Belum Lunas --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Denda Belum Lunas</h3>
                    <p class="text-xs text-slate-400">Anggota yang masih memiliki tunggakan</p>
                </div>
            </div>
            @if($dendaAktif->isEmpty())
                <div class="py-12 text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-600">Tidak ada tunggakan denda!</p>
                    <p class="text-xs text-slate-400 mt-1">Semua anggota sudah melunasi denda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-red-50 text-slate-500 text-xs uppercase tracking-wide">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Anggota</th>
                                <th class="px-4 py-3 text-left">Buku Dipinjam</th>
                                <th class="px-4 py-3 text-center">Tgl Kembali (Rencana)</th>
                                <th class="px-4 py-3 text-center">Keterlambatan</th>
                                <th class="px-4 py-3 text-right">Jumlah Denda</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($dendaAktif as $i => $d)
                                <tr class="hover:bg-red-50/40 transition">
                                    <td class="px-4 py-3.5 text-slate-400 text-xs">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3.5">
                                        <p class="font-semibold text-slate-800">{{ $d->anggota->nama }}</p>
                                        <p class="text-xs text-slate-400">{{ $d->anggota->nis }} · {{ $d->anggota->kelas }}</p>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <p class="text-slate-700 font-medium">{{ $d->buku->judul }}</p>
                                        <p class="text-xs text-slate-400">{{ $d->buku->pengarang }}</p>
                                    </td>
                                    <td class="px-4 py-3.5 text-center text-xs text-slate-500">
                                        {{ $d->tgl_kembali_rencana->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        @php $hari = (int) now()->diffInDays($d->tgl_kembali_rencana) @endphp
                                        <span class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-semibold">
                                            {{ $hari }} hari
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-right font-bold text-red-600">
                                        Rp {{ number_format($d->denda, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <form action="{{ route('denda.lunaskan', $d->id) }}" method="POST" class="inline"
                                              data-confirm="Tandai denda Rp {{ number_format($d->denda, 0, ',', '.') }} atas nama {{ $d->anggota->nama }} sebagai LUNAS?"
                                              data-confirm-title="Tandai Lunas?"
                                              data-confirm-btn="Ya, Lunas"
                                              data-confirm-class="bg-emerald-500 hover:bg-emerald-600"
                                              data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'>
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Tandai Lunas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-red-50 font-semibold">
                                <td colspan="5" class="px-4 py-3 text-sm text-slate-700">Total Tunggakan</td>
                                <td class="px-4 py-3 text-right text-red-600 font-bold">Rp {{ number_format($totalDendaAktif, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        {{-- Denda Sudah Lunas --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Riwayat Denda Lunas</h3>
                    <p class="text-xs text-slate-400">Denda yang sudah diselesaikan</p>
                </div>
            </div>
            @if($dendaLunas->isEmpty())
                <div class="py-10 text-center text-slate-400 text-sm">Belum ada riwayat denda lunas.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-green-50 text-slate-500 text-xs uppercase tracking-wide">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Anggota</th>
                                <th class="px-4 py-3 text-left">Buku</th>
                                <th class="px-4 py-3 text-center">Tgl Dikembalikan</th>
                                <th class="px-4 py-3 text-right">Denda Dibayar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($dendaLunas as $i => $d)
                                <tr class="hover:bg-green-50/30 transition">
                                    <td class="px-4 py-3 text-slate-400 text-xs">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-slate-800">{{ $d->anggota->nama }}</p>
                                        <p class="text-xs text-slate-400">{{ $d->anggota->nis }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ $d->buku->judul }}</td>
                                    <td class="px-4 py-3 text-center text-xs text-slate-500">
                                        {{ $d->tgl_kembali_aktual->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-green-700">
                                        Rp {{ number_format($d->denda, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
