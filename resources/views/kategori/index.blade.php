<x-app-layout>
    <x-slot name="title">Kategori Buku</x-slot>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Kategori Buku</h2>
        </div>
    </x-slot>

    <div x-data="{ showModalKategori: false, showModalEditKategori: false, editKategoriData: {} }" class="bg-slate-50 min-h-screen p-4 sm:p-6 space-y-6 relative">

        @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ═══ TOOLBAR ═══ --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" placeholder="Cari nama kategori..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm outline-none transition">
            </div>
            <button @click="showModalKategori = true" class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </button>
        </div>

        {{-- ═══ TABEL DATA ═══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800">Daftar Kategori</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $kategoris->count() }} data ditemukan</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-white text-slate-400 text-[11px] uppercase tracking-wider font-bold border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 w-16">No</th>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kategoris as $i => $kategori)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 text-slate-400">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $kategori->nama_kategori }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" @click="editKategoriData = { id: {{ $kategori->id }}, nama_kategori: '{{ addslashes($kategori->nama_kategori) }}', url: '{{ route('kategori.update', $kategori->id) }}' }; showModalEditKategori = true" 
                                       class="w-8 h-8 rounded-md bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline"
                                          data-confirm="Hapus kategori '{{ $kategori->nama_kategori }}'? Buku yang terhubung tidak akan terhapus."
                                          data-confirm-title="Hapus Kategori?"
                                          data-confirm-btn="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 rounded-md bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- MODAL KATEGORI --}}
        <div x-show="showModalKategori" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalKategori" @click="showModalKategori = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalKategori" x-transition.scale.origin.bottom class="inline-block w-full max-w-lg px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kategori
                        </h3>
                        <button @click="showModalKategori = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kategori" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalKategori = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- MODAL EDIT KATEGORI --}}
        <div x-show="showModalEditKategori" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalEditKategori" @click="showModalEditKategori = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalEditKategori" x-transition.scale.origin.bottom class="inline-block w-full max-w-lg px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Kategori
                        </h3>
                        <button @click="showModalEditKategori = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form :action="editKategoriData.url" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kategori" x-model="editKategoriData.nama_kategori" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalEditKategori = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>