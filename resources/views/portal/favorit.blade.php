<x-member-layout>
    <div class="py-6 space-y-10">

        <!-- Page Title -->
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buku Favorit</h2>
            <p class="text-slate-500 mt-1">Simpan buku yang kamu sukai dan temukan rekomendasi serupa.</p>
        </div>

        <!-- ── SECTION 1: Favorit Saya ── -->
        <div>
            <h3 class="text-base font-bold text-slate-500 uppercase tracking-widest mb-5">Koleksi Favorit Saya</h3>
            
            @if($favorits->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($favorits as $buku)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-xl hover:border-slate-300 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                            <a href="{{ route('anggota.buku.show', $buku->id) }}" class="aspect-[3/4] bg-slate-100 relative overflow-hidden block">
                                @if($buku->cover)
                                    <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <!-- Hover overlay with heart button -->
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <form action="{{ route('anggota.buku.favorit', $buku->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition shadow-md" title="Hapus dari Favorit">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </a>
                            <div class="p-5 flex flex-col flex-1 bg-gradient-to-b from-white to-slate-50/50">
                                <span class="text-[10px] font-extrabold text-rose-500 uppercase tracking-widest mb-2">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                <h4 class="font-bold text-slate-900 mb-1 leading-snug line-clamp-2" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                <p class="text-xs text-slate-500 truncate mt-auto">{{ $buku->penulis }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl border border-dashed border-slate-300 shadow-sm p-14 text-center">
                    <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada buku favorit</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">Saat menjelajahi Daftar Koleksi, klik ikon hati pada buku yang kamu suka untuk menyimpannya di sini.</p>
                    <a href="{{ route('anggota.katalog') }}" class="mt-6 inline-flex items-center gap-2 bg-rose-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-rose-600 transition shadow-lg shadow-rose-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Jelajahi Koleksi
                    </a>
                </div>
            @endif
        </div>

        <!-- ── SECTION 2: Mungkin Kamu Juga Suka ── -->
        <div>
            <div class="flex items-end justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-500 uppercase tracking-widest">Mungkin Kamu Juga Suka</h3>
                    <p class="text-slate-400 text-sm mt-1">Rekomendasi buku populer dari perpustakaan.</p>
                </div>
                <a href="{{ route('anggota.katalog') }}" class="text-sm font-bold text-rose-500 hover:text-rose-600 bg-rose-50 px-4 py-2 rounded-full transition">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($rekomendasi as $buku)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-xl hover:border-slate-300 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                        <a href="{{ route('anggota.buku.show', $buku->id) }}" class="aspect-[3/4] bg-slate-100 relative overflow-hidden block">
                            @if($buku->cover)
                                <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-5 flex flex-col flex-1 bg-gradient-to-b from-white to-slate-50/50">
                            <span class="text-[10px] font-extrabold text-rose-500 uppercase tracking-widest mb-2">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                            <h4 class="font-bold text-slate-900 mb-1 leading-snug line-clamp-2" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                            <p class="text-xs text-slate-500 truncate mt-auto">{{ $buku->penulis }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-member-layout>
