<x-member-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-slate-900 tracking-tight">Keranjang</h1>
                <p class="text-slate-500 mt-1 text-sm">Yuk selesaikan peminjaman kamu</p>
            </div>

            @if($bukus->isEmpty())
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="w-48 h-48 mb-6 text-slate-200">
                        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="30" y="80" width="140" height="80" rx="10" fill="currentColor" opacity="0.5"/>
                            <path d="M40 80L55 160H145L160 80H40Z" fill="currentColor"/>
                            <circle cx="70" cy="175" r="10" fill="#64748B"/>
                            <circle cx="130" cy="175" r="10" fill="#64748B"/>
                            <path d="M10 40H30L40 80" stroke="#64748B" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Ups, keranjang kamu kosong</h3>
                    <p class="text-slate-500 mb-8 text-sm">Yuk tambahkan buku favorit kamu ke keranjang</p>
                    <a href="{{ route('anggota.katalog') }}" class="bg-blue-900 text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-colors" style="background-color:#1e3a5f">
                        Cari buku sekarang
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    <!-- Kolom Kiri: Daftar Buku -->
                    <div class="flex-1 w-full space-y-5">
                        @foreach($bukus as $buku)
                            <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-col sm:flex-row gap-5 hover:border-slate-300 transition-colors">
                                <!-- Cover -->
                                <div class="w-24 sm:w-28 aspect-[2/3] rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                                    @if($buku->cover)
                                        <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Detail Buku -->
                                <div class="flex-1 flex flex-col justify-between min-w-0">
                                    <div>
                                        <h3 class="font-extrabold text-slate-900 text-lg leading-tight mb-2" title="{{ $buku->judul }}">
                                            {{ $buku->judul }}
                                        </h3>
                                        <p class="text-sm text-slate-600 mb-2 truncate">
                                            {{ $buku->penulis }} (Pengarang) @if($buku->penerbit) ; {{ $buku->penerbit }} (Penerbit) @endif
                                        </p>
                                        <p class="text-xs text-slate-400 mb-4">
                                            Lokasi Asal: Perpustakaan Utama - {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 mt-auto">
                                        <div class="flex-1">
                                            <input type="text" disabled placeholder="Catatan" class="w-full text-sm border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed placeholder:text-slate-400 focus:ring-0">
                                        </div>
                                        
                                        <form action="{{ route('anggota.keranjang.hapus', $buku->id) }}" method="POST" class="shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-lg bg-white border border-rose-300 text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-colors flex items-center justify-center" title="Hapus dari Keranjang">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="mt-6 flex flex-col sm:flex-row">
                            <a href="{{ route('anggota.katalog') }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 hover:border-slate-400 px-6 py-2.5 rounded-lg font-bold text-sm transition-colors gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Buku
                            </a>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Ringkasan Pengajuan -->
                    <div class="w-full lg:w-72 shrink-0">
                        <div class="bg-slate-50 rounded-xl border border-slate-200 p-5 sticky top-24">
                            <h3 class="font-extrabold text-slate-900 text-base mb-5">Ringkasan Pengajuan</h3>
                            
                            <div class="space-y-3 text-sm border-b border-slate-200 pb-5 mb-5">
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-slate-600 font-medium">Total Buku</span>
                                    <span class="font-bold text-slate-900">{{ $bukus->count() }} item</span>
                                </div>
                                <div class="flex items-center justify-between w-full">
                                    <span class="text-slate-600 font-medium">Durasi</span>
                                    <span class="inline-block font-bold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-md text-xs">14 Hari</span>
                                </div>
                            </div>
                            
                            <div class="mb-5 flex items-start gap-2 text-slate-600 bg-white p-3 rounded-lg border border-slate-200">
                                <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-[11px] leading-relaxed font-medium">
                                    Butuh persetujuan pustakawan sebelum buku fisik diambil.
                                </p>
                            </div>

                            <form action="{{ route('anggota.keranjang.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-sm transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Ajukan Pinjaman
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-member-layout>
