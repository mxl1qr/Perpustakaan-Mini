<x-member-layout>
    <x-slot name="title">Koleksi Buku</x-slot>
    <div class="py-6">
        <!-- Search Box & Filters -->
        <div class="mb-10 max-w-3xl mx-auto">
            <form action="{{ route('anggota.katalog') }}" method="GET" class="relative mb-4">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku atau penulis..." class="w-full pl-11 pr-24 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-slate-800">
                <button type="submit" class="absolute right-2 top-2 bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">Cari</button>
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
            </form>

            <!-- Filter Kategori (Pills) -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2">Kategori:</span>
                <a href="{{ route('anggota.katalog', ['search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all border shadow-sm hover:-translate-y-0.5 {{ !request('kategori') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">
                    Semua
                </a>
                @foreach($kategoriList as $k)
                    <a href="{{ route('anggota.katalog', ['kategori' => $k->id, 'search' => request('search')]) }}" 
                       class="px-5 py-2 rounded-full text-sm font-bold transition-all border shadow-sm hover:-translate-y-0.5 {{ request('kategori') == $k->id ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="max-w-6xl mx-auto flex flex-wrap justify-center gap-8">
            @forelse($buku as $b)
                <a href="{{ route('anggota.buku.show', $b->id) }}" class="w-[160px] sm:w-[180px] md:w-[200px] lg:w-[220px] bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-xl hover:border-slate-300 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                    <div class="aspect-[3/4] bg-slate-100 relative overflow-hidden">
                        @if($b->cover)
                            <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <span class="bg-{{ $b->stok > 0 ? 'emerald' : 'rose' }}-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md w-max mb-2">
                                {{ $b->stok > 0 ? 'Tersedia: '.$b->stok : 'Habis' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-1 bg-gradient-to-b from-white to-slate-50/50">
                        <span class="text-[10px] font-extrabold text-rose-500 uppercase tracking-widest mb-2">{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                        <h4 class="font-bold text-slate-900 mb-1 leading-snug line-clamp-2" title="{{ $b->judul }}">{{ $b->judul }}</h4>
                        <p class="text-xs text-slate-500 truncate mt-auto">{{ $b->penulis }}</p>
                    </div>
                </a>
            @empty
                <div class="w-full max-w-2xl bg-white rounded-3xl p-16 text-center shadow-sm border border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Buku tidak ditemukan</h3>
                    <p class="text-slate-500">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $buku->links() }}
        </div>
    </div>
</x-member-layout>
