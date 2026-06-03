<x-app-layout>
    <x-slot name="title">Laporan</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">Laporan</h2>
                <p class="text-xs text-gray-400 mt-0.5">Laporan peminjaman dan buku terpopuler</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('laporan.cetak-transaksi') }}"
                   target="_blank"
                   class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Rekap Transaksi PDF
                </a>
                <button onclick="window.print()"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="bg-slate-50 min-h-screen p-4 sm:p-6 space-y-5">

        {{-- ═══ LAPORAN PEMINJAMAN ═══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Statistik Keseluruhan --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Laporan Peminjaman</h3>
                        <p class="text-xs text-slate-400">Statistik keseluruhan transaksi</p>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400 inline-block"></span>
                            <span class="text-sm text-slate-600">Total Semua Peminjaman</span>
                        </div>
                        <span class="font-bold text-slate-800 text-lg">{{ $totalSemuaPeminjaman }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                            <span class="text-sm text-slate-600">Sedang Dipinjam</span>
                        </div>
                        <span class="font-bold text-blue-600 text-lg">{{ $totalDipinjam }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>
                            <span class="text-sm text-slate-600">Sudah Dikembalikan</span>
                        </div>
                        <span class="font-bold text-green-600 text-lg">{{ $totalDikembalikan }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span>
                            <span class="text-sm text-slate-600">Dikembalikan Terlambat</span>
                        </div>
                        <span class="font-bold text-red-500 text-lg">{{ $totalTerlambat }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-violet-400 inline-block"></span>
                            <span class="text-sm text-slate-600">Peminjaman Bulan Ini</span>
                        </div>
                        <span class="font-bold text-violet-600 text-lg">{{ $bulanIniPinjam }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-400 inline-block"></span>
                            <span class="text-sm text-slate-600">Dikembalikan Bulan Ini</span>
                        </div>
                        <span class="font-bold text-teal-600 text-lg">{{ $bulanIniKembali }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                            <span class="text-sm text-slate-600">Total Denda Terkumpul</span>
                        </div>
                        <span class="font-bold text-amber-600">Rp
                            {{ number_format($totalDendaAll, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="px-5 pb-5">
                    <a href="{{ route('peminjaman.index') }}"
                        class="block w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium py-2 rounded-lg transition">
                        Lihat Semua Transaksi →
                    </a>
                </div>
            </div>

            {{-- Chart 6 Bulan --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Grafik Peminjaman 6 Bulan Terakhir</h3>
                        <p class="text-xs text-slate-400">Tren bulanan peminjaman, pengembalian, dan keterlambatan</p>
                    </div>
                    <div class="hidden sm:flex gap-3 text-xs text-slate-500">
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>Dipinjam</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>Kembali</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>Terlambat</span>
                    </div>
                </div>
                <canvas id="laporanChart" height="180"></canvas>
            </div>
        </div>

        {{-- ═══ LAPORAN BUKU TERPOPULER ═══ --}}
        <div class="mt-4 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Laporan Buku Terpopuler</h3>
                        <p class="text-xs text-slate-400">Berdasarkan total jumlah peminjaman</p>
                    </div>
                </div>
                <span class="text-xs bg-violet-100 text-violet-700 px-2.5 py-1 rounded-full font-semibold">Top 10</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-center w-14">Rank</th>
                            <th class="px-4 py-3 text-left">Judul Buku</th>
                            <th class="px-4 py-3 text-left">Pengarang</th>
                            <th class="px-4 py-3 text-center">Stok Saat Ini</th>
                            <th class="px-4 py-3 text-center">Total Dipinjam</th>
                            <th class="px-4 py-3 text-left w-40">Popularitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php $maxPinjam = $bukuPopuler->max('peminjaman_count') ?: 1; @endphp
                        @forelse($bukuPopuler as $rank => $buku)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-4 py-3.5 text-center">
                                    <div
                                        class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center font-bold text-sm
                                                        {{ $rank === 0 ? 'bg-amber-400 text-white' : ($rank === 1 ? 'bg-slate-300 text-slate-700' : ($rank === 2 ? 'bg-orange-300 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                        {{ $rank + 1 }}
                                    </div>
                                </td>
                                <td class="px-4 py-3.5">
                                    <p class="font-semibold text-slate-800">{{ $buku->judul }}</p>
                                </td>
                                <td class="px-4 py-3.5 text-slate-500">{{ $buku->pengarang }}</td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="text-slate-700 font-medium">{{ $buku->stok }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span class="font-bold {{ $rank === 0 ? 'text-amber-600 text-lg' : 'text-slate-700' }}">
                                        {{ $buku->peminjaman_count }}x
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                            <div class="h-2 rounded-full {{ $rank === 0 ? 'bg-amber-400' : 'bg-blue-400' }}"
                                                style="width: {{ $maxPinjam > 0 ? round(($buku->peminjaman_count / $maxPinjam) * 100) : 0 }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs text-slate-400 w-8 text-right">{{ $maxPinjam > 0 ? round(($buku->peminjaman_count / $maxPinjam) * 100) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada data peminjaman
                                    buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            const ctx = document.getElementById('laporanChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        { label: 'Dipinjam', data: @json($chartPinjam), borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.08)', tension: 0.4, fill: true, pointRadius: 4 },
                        { label: 'Dikembalikan', data: @json($chartKembali), borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.06)', tension: 0.4, fill: true, pointRadius: 4 },
                        { label: 'Terlambat', data: @json($chartLambat), borderColor: '#f87171', backgroundColor: 'rgba(248,113,113,0.05)', tension: 0.4, fill: true, pointRadius: 4 },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, color: '#94a3b8', font: { size: 11 } }, grid: { color: '#f1f5f9' } },
                        x: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { display: false } }
                    }
                }
            });
        </script>
    @endpush

    @push('styles')
    <style>
        @media print {
            /* Sembunyikan elemen UI saat print */
            nav, aside, header, footer, .no-print,
            #laporanChart, canvas { display: none !important; }

            /* Tampilkan hanya area print */
            .print-only { display: block !important; }

            body { background: white !important; font-size: 12px; }

            .print-table th, .print-table td {
                border: 1px solid #e2e8f0;
                padding: 6px 10px;
                text-align: left;
            }
            .print-table th { background: #f8fafc; font-weight: 700; }
            .print-table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        }
        .print-only { display: none; }
    </style>
    @endpush
</x-app-layout>