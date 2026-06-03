<x-member-layout>
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('anggota.portal') }}" class="text-slate-500 hover:text-blue-600 transition-colors">
                    Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('anggota.katalog') }}" class="text-slate-500 hover:text-blue-600 transition-colors">Katalog</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-300 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-slate-900 font-semibold truncate max-w-[150px] sm:max-w-xs">{{ $buku->judul }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            {{-- Bagian Kiri: Gambar --}}
            <div class="md:w-1/3 lg:w-1/4 p-6 sm:p-8 bg-slate-50 flex flex-col items-center border-b md:border-b-0 md:border-r border-slate-200">
                <div class="w-full aspect-[2/3] rounded-2xl shadow-lg overflow-hidden bg-white border border-slate-200 group relative">
                    @if($buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 text-white p-6 text-center">
                            <svg class="w-16 h-16 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-70">No Cover Available</span>
                        </div>
                    @endif
                    
                    {{-- Status Badge on Image --}}
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold shadow-md {{ $buku->stok > 0 ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                            {{ $buku->stok > 0 ? 'Tersedia' : 'Kosong' }}
                        </span>
                    </div>
                </div>

                <div class="mt-8 w-full space-y-3">
                    {{-- Form Pinjam --}}
                    <form action="{{ route('anggota.buku.pinjam', $buku->id) }}" method="POST">
                        @csrf
                        <button type="submit" @if($buku->stok <= 0) disabled @endif
                                class="w-full py-3.5 px-4 rounded-xl font-bold transition-all flex items-center justify-center gap-2 shadow-sm
                                       {{ $buku->stok > 0 
                                          ? 'bg-blue-600 hover:bg-blue-700 text-white' 
                                          : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            + Keranjang
                        </button>
                    </form>

                    {{-- Form Favorit --}}
                    <form action="{{ route('anggota.buku.favorit', $buku->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold border border-slate-200 transition-all flex items-center justify-center gap-2 {{ $isFavorit ? 'bg-rose-50 text-rose-500 border-rose-100' : 'text-slate-600 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 {{ $isFavorit ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            {{ $isFavorit ? 'Favorit Saya' : 'Tambah Favorit' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Bagian Kanan: Konten --}}
            <div class="flex-1 p-6 sm:p-10 space-y-8">
                <div>
                    <span class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
                        {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-2 tracking-tight">
                        {{ $buku->judul }}
                    </h1>
                    <p class="text-lg text-slate-500 font-medium">Oleh <span class="text-slate-800 font-bold">{{ $buku->penulis }}</span></p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                        Ringkasan Buku
                    </h3>
                    @if($buku->deskripsi)
                        <p class="text-slate-600 leading-relaxed">
                            {{ $buku->deskripsi }}
                        </p>
                    @else
                        <p class="text-slate-400 leading-relaxed italic">
                            "Deskripsi untuk buku ini belum tersedia. Silakan meminjam buku ini untuk menjelajahi isinya secara lengkap."
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-6 border-t border-slate-100">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Penerbit</p>
                        <p class="font-bold text-slate-700 leading-tight">{{ $buku->penerbit ?: '-' }}</p>
                    </div>
                    @if($buku->isbn)
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">ISBN</p>
                        <p class="font-bold text-slate-700 font-mono text-sm">{{ $buku->isbn }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tahun Terbit</p>
                        <p class="font-bold text-slate-700">{{ $buku->tahun_terbit }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Stok Tersedia</p>
                        <p class="font-bold {{ $buku->stok > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                            {{ $buku->stok }} Eksemplar
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Buku Terkait --}}
    @if($bukuLain->count() > 0)
    <div class="mt-12">
        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center justify-between">
            <span>Mungkin Kamu Suka</span>
            <a href="{{ route('anggota.katalog', ['kategori' => $buku->kategori_id]) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-4 py-2 rounded-full transition">Lihat Semua</a>
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($bukuLain as $lain)
                <a href="{{ route('anggota.buku.show', $lain->id) }}" class="bg-white p-3 rounded-2xl border border-slate-200 hover:shadow-md transition-all group flex flex-col h-full">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden bg-slate-100 mb-3 shrink-0">
                        @if($lain->cover)
                            <img src="{{ Storage::url($lain->cover) }}" alt="{{ $lain->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col flex-1">
                        <h4 class="font-bold text-slate-800 text-xs line-clamp-2 leading-snug mb-1">{{ $lain->judul }}</h4>
                        <p class="text-[10px] text-slate-500 truncate mt-auto">{{ $lain->penulis }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</x-member-layout>
