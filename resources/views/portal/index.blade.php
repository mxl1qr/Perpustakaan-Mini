<x-member-layout>
    <div class="py-6">
        @if(isset($notifikasiPeminjaman) && $notifikasiPeminjaman->isNotEmpty())
            <div class="mb-8 p-5 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 rounded-3xl flex flex-col gap-2 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-extrabold text-slate-800 text-base">Buku Berhasil Dipinjam! 🎉</p>
                        <p class="text-xs text-slate-600 mt-1">Permintaan peminjaman Anda telah divalidasi dan disetujui oleh admin:</p>
                        <ul class="list-disc list-inside mt-2.5 text-xs font-bold text-emerald-700 space-y-1">
                            @foreach($notifikasiPeminjaman as $notif)
                                <li>{{ $notif->buku->judul }} &mdash; Batas kembali: {{ $notif->tgl_kembali_rencana->format('d/m/Y') }}</li>
                            @endforeach
                        </ul>
                        <p class="text-[10px] text-slate-400 mt-3 font-medium">Silakan hubungi pustakawan di meja utama untuk pengambilan buku fisik.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-rose-500 rounded-3xl shadow-xl p-10 mb-12 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="absolute bottom-0 left-1/4 w-32 h-32 rounded-full bg-white opacity-5 mix-blend-overlay"></div>
            <div class="relative z-10">
                <h3 class="text-4xl font-extrabold mb-3 tracking-tight">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h3>
                <p class="text-blue-50 text-lg max-w-2xl leading-relaxed">Selamat datang kembali di Portal Siswa. Apa yang ingin kamu baca hari ini?</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Kiri: Rekomendasi Buku -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pilihan Pustakawan</h3>
                        <p class="text-slate-500 text-sm mt-1">Buku-buku terbaik yang wajib kamu baca minggu ini.</p>
                    </div>
                    <a href="{{ route('anggota.katalog') }}" class="text-sm font-bold text-rose-500 hover:text-rose-600 bg-rose-50 px-4 py-2 rounded-full transition">Lihat Semua</a>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($bukuTerbaru as $buku)
                        <a href="{{ route('anggota.buku.show', $buku->id) }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-xl hover:border-slate-300 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                            <div class="aspect-[3/4] bg-slate-100 relative overflow-hidden">
                                @if($buku->cover)
                                    <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                    <span class="bg-{{ $buku->stok > 0 ? 'emerald' : 'rose' }}-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md w-max mb-2">
                                        {{ $buku->stok > 0 ? 'Tersedia: '.$buku->stok : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 flex flex-col flex-1 bg-gradient-to-b from-white to-slate-50/50">
                                <span class="text-[10px] font-extrabold text-rose-500 uppercase tracking-widest mb-2">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                <h4 class="font-bold text-slate-900 mb-1 leading-snug line-clamp-2" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                <p class="text-xs text-slate-500 truncate mt-auto">{{ $buku->penulis }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-500 border border-slate-200 shadow-sm">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            Belum ada rekomendasi buku saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kanan: Agenda Literasi -->
            <div class="w-full lg:w-96 shrink-0">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Agenda Literasi</h3>
                        <p class="text-slate-500 text-sm mt-1">Jadwal kegiatan perpus terdekat.</p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 mb-6 text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-blue-500 opacity-20 group-hover:scale-150 transition-transform duration-700"></div>
                    <p class="text-xs font-bold text-blue-300 mb-2 tracking-widest uppercase">Besok, 08:00 WIB</p>
                    <h4 class="text-xl font-bold mb-2">Bedah Buku: Atomic Habits</h4>
                    <p class="text-sm text-slate-300 mb-6 leading-relaxed">Bergabung bersama Bapak Budi di Aula Perpustakaan untuk membedah buku tentang kebiasaan kecil.</p>
                    <button class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold py-2.5 px-5 rounded-xl transition w-full shadow-lg shadow-blue-900/50">Ikuti Agenda</button>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-4 border-l-4 border-l-rose-500 hover:shadow-md transition group cursor-pointer">
                    <p class="text-xs font-bold text-rose-500 mb-1 tracking-widest uppercase">24 Mei 2026</p>
                    <h4 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-rose-600 transition-colors">Batas Waktu Pengembalian Massal</h4>
                    <p class="text-sm text-slate-500">Harap mengembalikan seluruh buku pinjaman sebelum libur semester ganjil dimulai.</p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 text-center border-dashed">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Belum ada agenda lain.</p>
                </div>
            </div>
        </div>
    </div>
</x-member-layout>
