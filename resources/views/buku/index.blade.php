<x-app-layout>
    <x-slot name="title">Koleksi Buku</x-slot>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Daftar Koleksi Buku</h2>
        </div>
    </x-slot>

    <div x-data="{ showModalBuku: false, showModalEditBuku: false, editBukuData: {}, activeCategory: 'Semua', viewMode: 'grid', searchQuery: '' }" class="bg-slate-50 min-h-screen p-4 sm:p-6 space-y-6 relative">

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ═══ HERO BANNER ═══ --}}
        <div class="bg-[#1e3a5f] rounded-2xl p-6 relative overflow-hidden">
            {{-- Decorative Book Icon --}}
            <svg class="absolute -right-4 -bottom-4 w-48 h-48 text-white/5 transform -rotate-12" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
            </svg>
            <div class="relative z-10">
                <h1 class="text-white font-bold text-2xl flex items-center gap-2">
                    Daftar Koleksi Buku <span class="text-2xl">📖</span>
                </h1>
                <p class="text-blue-200 text-sm mt-1.5">Kelola koleksi buku perpustakaan — tambah, edit, dan hapus koleksi buku.</p>
            </div>
        </div>

        {{-- ═══ STAT CARDS ═══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {{-- Total Buku --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $totalBuku }}</p>
                <p class="text-sm text-slate-400 mt-1">Total Buku</p>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-blue-50/50 rounded-full"></div>
            </div>

            {{-- Buku Baru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $bukuBaru }}</p>
                <p class="text-sm text-slate-400 mt-1">Buku Baru Bulan Ini</p>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-green-50/50 rounded-full"></div>
            </div>
        </div>

        {{-- ═══ TOOLBAR ═══ --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" x-model="searchQuery" placeholder="Cari Judul/Pengarang/ISBN..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm outline-none transition">
            </div>
            <button @click="showModalBuku = true" class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Buku
            </button>
        </div>

        {{-- ═══ FILTERS ═══ --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto w-full pb-2 sm:pb-0 hide-scrollbar">
                <button @click="activeCategory = 'Semua'" :class="activeCategory === 'Semua' ? 'bg-[#1e3a5f] text-white border-[#1e3a5f]' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'" class="shrink-0 px-4 py-1.5 border text-xs font-semibold rounded-full shadow-sm transition">Semua</button>
                @foreach($kategoris as $kat)
                    <button @click="activeCategory = '{{ addslashes($kat->nama_kategori) }}'" :class="activeCategory === '{{ addslashes($kat->nama_kategori) }}' ? 'bg-[#1e3a5f] text-white border-[#1e3a5f]' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300'" class="shrink-0 px-4 py-1.5 border text-xs font-medium rounded-full transition">
                        {{ $kat->nama_kategori }}
                    </button>
                @endforeach
            </div>
            <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-lg p-1 shrink-0">
                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-slate-100 text-slate-800' : 'text-slate-400 hover:text-slate-600'" class="p-1.5 rounded-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
                <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-slate-100 text-slate-800' : 'text-slate-400 hover:text-slate-600'" class="p-1.5 rounded-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- ═══ BUKU GRID & LIST VIEW ═══ --}}
        <div>
            {{-- GRID VIEW --}}
            <div x-show="viewMode === 'grid'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5" style="display: none;">
                @php
                    $colors = [
                        'from-blue-600 to-indigo-900',
                        'from-emerald-600 to-teal-900',
                        'from-amber-600 to-orange-900',
                        'from-rose-600 to-red-900',
                        'from-violet-600 to-purple-900',
                        'from-cyan-600 to-blue-900',
                    ];
                @endphp

                @forelse($bukus as $buku)
                    @php 
                        $gradient = $colors[$buku->id % count($colors)];
                        $kategoriName = $buku->kategori ? $buku->kategori->nama_kategori : 'Umum';
                    @endphp
                    <div x-show="(activeCategory === 'Semua' || '{{ addslashes($kategoriName) }}' === activeCategory) && 
                                ('{{ strtolower(addslashes($buku->judul)) }}'.includes(searchQuery.toLowerCase()) || 
                                 '{{ strtolower(addslashes($buku->penulis)) }}'.includes(searchQuery.toLowerCase()) || 
                                 '{{ strtolower(addslashes($buku->isbn ?? '')) }}'.includes(searchQuery.toLowerCase()))"
                         class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group relative transition-all duration-300">
                        
                        {{-- Cover --}}
                        @if($buku->cover)
                        <div class="aspect-[2/3] w-full bg-slate-100 relative overflow-hidden">
                            <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                            {{-- Overlay --}}
                            <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/40 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            <div class="absolute inset-0 p-4 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <span class="bg-[#1e3a5f]/80 backdrop-blur-sm text-white text-[10px] uppercase font-bold tracking-wider px-2 py-1 rounded">
                                        {{ $kategoriName }}
                                    </span>
                        @else
                        <div class="aspect-[2/3] w-full bg-gradient-to-br {{ $gradient }} relative p-4 flex flex-col justify-between overflow-hidden">
                            {{-- Overlay --}}
                            <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/40 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/60 to-transparent"></div>
                            
                            <div class="relative z-10 flex justify-between items-start">
                                <span class="bg-[#1e3a5f]/80 backdrop-blur-sm text-white text-[10px] uppercase font-bold tracking-wider px-2 py-1 rounded line-clamp-1">
                                    {{ $kategoriName }}
                                </span>
                        @endif
                                
                                {{-- Action buttons overlay (visible on hover) --}}
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" @click="editBukuData = { id: {{ $buku->id }}, judul: '{{ addslashes($buku->judul) }}', penulis: '{{ addslashes($buku->penulis) }}', penerbit: '{{ addslashes($buku->penerbit) }}', isbn: '{{ addslashes($buku->isbn ?? '') }}', deskripsi: '{{ addslashes($buku->deskripsi ?? '') }}', tahun_terbit: {{ $buku->tahun_terbit }}, stok: {{ $buku->stok }}, kategori_id: {{ $buku->kategori_id ?? 'null' }}, url: '{{ route('buku.update', $buku->id) }}' }; showModalEditBuku = true" class="w-7 h-7 rounded bg-white/20 hover:bg-white/40 backdrop-blur-md flex items-center justify-center text-white transition pointer-events-auto cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="inline pointer-events-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded bg-red-500/80 hover:bg-red-600/90 backdrop-blur-md flex items-center justify-center text-white transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <h3 class="text-white font-bold text-lg leading-snug pb-2 relative z-10 drop-shadow-md">
                                {{ $buku->judul }}
                            </h3>
                            @if($buku->cover) </div> @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-col p-4 flex justify-between gap-3 bg-white flex-1">
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $buku->penulis }}</p>
                            </div>
                            <div class="flex flex-row items-center gap-1.5 text-xs font-semibold text-slate-600">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Stok: <span class="{{ $buku->stok > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $buku->stok }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl shadow-sm border border-slate-100">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <p class="text-slate-500 font-medium">Belum ada koleksi buku.</p>
                    </div>
                @endforelse
            </div>

            {{-- LIST VIEW (TABLE) --}}
            <div x-show="viewMode === 'list'" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" style="display: none;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                <th class="px-6 py-4 w-16 text-center">NO</th>
                                <th class="px-6 py-4 w-24">COVER</th>
                                <th class="px-6 py-4">JUDUL BUKU</th>
                                <th class="px-6 py-4">PENGARANG</th>
                                <th class="px-6 py-4">KATEGORI</th>
                                <th class="px-6 py-4">STOK</th>
                                <th class="px-6 py-4 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($bukus as $index => $buku)
                                @php 
                                    $kategoriName = $buku->kategori ? $buku->kategori->nama_kategori : 'Umum';
                                @endphp
                                <tr x-show="(activeCategory === 'Semua' || '{{ addslashes($kategoriName) }}' === activeCategory) && 
                                           ('{{ strtolower(addslashes($buku->judul)) }}'.includes(searchQuery.toLowerCase()) || 
                                            '{{ strtolower(addslashes($buku->penulis)) }}'.includes(searchQuery.toLowerCase()) || 
                                            '{{ strtolower(addslashes($buku->isbn ?? '')) }}'.includes(searchQuery.toLowerCase()))"
                                    class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-slate-400 font-medium text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        @if($buku->cover)
                                            <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}" class="w-10 h-14 object-cover rounded shadow-sm border border-slate-200">
                                        @else
                                            <div class="w-10 h-14 bg-slate-100 rounded flex items-center justify-center border border-slate-200 text-slate-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $buku->judul }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $buku->penulis }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                            {{ $kategoriName }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 font-bold text-[13px] {{ $buku->stok > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                            {{ $buku->stok }}
                                            <span class="text-slate-400 font-normal">/ {{ $buku->stok }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" @click="editBukuData = { id: {{ $buku->id }}, judul: '{{ addslashes($buku->judul) }}', penulis: '{{ addslashes($buku->penulis) }}', penerbit: '{{ addslashes($buku->penerbit) }}', isbn: '{{ addslashes($buku->isbn ?? '') }}', deskripsi: '{{ addslashes($buku->deskripsi ?? '') }}', tahun_terbit: {{ $buku->tahun_terbit }}, stok: {{ $buku->stok }}, kategori_id: {{ $buku->kategori_id ?? 'null' }}, url: '{{ route('buku.update', $buku->id) }}' }; showModalEditBuku = true" class="w-8 h-8 rounded text-blue-500 hover:text-blue-600 hover:bg-blue-50 flex items-center justify-center transition border border-blue-200 bg-white shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="inline"
                                                  data-confirm="Hapus buku '{{ $buku->judul }}'? Tindakan ini tidak dapat dibatalkan."
                                                  data-confirm-title="Hapus Buku?"
                                                  data-confirm-btn="Ya, Hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded text-rose-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition border border-rose-200 bg-white shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                        Belum ada koleksi buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6 w-full">
            {{ $bukus->links() }}
        </div>

        {{-- MODAL BUKU --}}
        <div x-show="showModalBuku" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalBuku" @click="showModalBuku = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalBuku" x-transition.scale.origin.bottom class="inline-block w-full max-w-2xl px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Buku Baru
                        </h3>
                        <button @click="showModalBuku = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                                <input type="text" name="penulis" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                                <input type="text" name="penerbit" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ISBN <span class="text-slate-400 font-normal text-xs">(opsional)</span></label>
                                <input type="text" name="isbn" maxlength="20" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition" placeholder="Contoh: 978-602-xxx">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_terbit" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Stok <span class="text-red-500">*</span></label>
                                <input type="number" name="stok" value="1" required min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi <span class="text-slate-400 font-normal text-xs">(opsional)</span></label>
                                <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition resize-none" placeholder="Sinopsis atau deskripsi singkat buku..."></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Cover Buku</label>
                                <input type="file" name="cover" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP. Maks 3MB.</p>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalBuku = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT BUKU --}}
        <div x-show="showModalEditBuku" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalEditBuku" @click="showModalEditBuku = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalEditBuku" x-transition.scale.origin.bottom class="inline-block w-full max-w-2xl px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Buku
                        </h3>
                        <button @click="showModalEditBuku = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form :action="editBukuData.url" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" x-model="editBukuData.judul" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                                <input type="text" name="penulis" x-model="editBukuData.penulis" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                                <input type="text" name="penerbit" x-model="editBukuData.penerbit" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">ISBN <span class="text-slate-400 font-normal text-xs">(opsional)</span></label>
                                <input type="text" name="isbn" x-model="editBukuData.isbn" maxlength="20" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition" placeholder="Contoh: 978-602-xxx">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_terbit" x-model="editBukuData.tahun_terbit" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Stok <span class="text-red-500">*</span></label>
                                <input type="number" name="stok" x-model="editBukuData.stok" required min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori_id" x-model="editBukuData.kategori_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi <span class="text-slate-400 font-normal text-xs">(opsional)</span></label>
                                <textarea name="deskripsi" x-model="editBukuData.deskripsi" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition resize-none" placeholder="Sinopsis atau deskripsi singkat buku..."></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Cover Buku (Opsional)</label>
                                <input type="file" name="cover" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                                <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah cover. Maks 3MB.</p>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalEditBuku = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Update Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>