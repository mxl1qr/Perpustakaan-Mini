<x-app-layout>
    <x-slot name="title">Data Anggota</x-slot>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800">Data Anggota</h2>
        </div>
    </x-slot>

    <div x-data="{ showModalAnggota: false, showModalEditAnggota: false, editAnggotaData: {} }" class="bg-slate-50 min-h-screen p-4 sm:p-6 space-y-6 relative">

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
                    Data Anggota Perpustakaan <span class="text-2xl">📋</span>
                </h1>
                <p class="text-blue-200 text-sm mt-1.5">Kelola data anggota perpustakaan — tambah, edit, dan hapus anggota</p>
            </div>
        </div>

        {{-- ═══ STAT CARDS ═══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {{-- Total Anggota --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $totalAnggota }}</p>
                <p class="text-sm text-slate-400 mt-1">Total Anggota</p>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-blue-50/50 rounded-full"></div>
            </div>

            {{-- Anggota Baru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $anggotaBaru }}</p>
                <p class="text-sm text-slate-400 mt-1">Anggota Baru Bulan Ini</p>
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-green-50/50 rounded-full"></div>
            </div>
        </div>

        {{-- ═══ TOOLBAR ═══ --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('anggota.index') }}" method="GET" class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota berdasarkan nama, NIS, atau kelas..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm outline-none transition">
            </form>
            <button @click="showModalAnggota = true" class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Anggota
            </button>
        </div>

        {{-- ═══ TABEL DATA ═══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800">Daftar Anggota</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $totalAnggota }} anggota terdaftar</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-white text-slate-400 text-[11px] uppercase tracking-wider font-bold border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 w-16">No</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">NIS</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Kontak</th>
                            <th class="px-6 py-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($anggotas as $i => $anggota)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 text-slate-400">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $anggota->nama }}</p>
                                @if($anggota->user)
                                    @if(!$anggota->user->admin_verified_at)
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Verifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $anggota->nis }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $anggota->kelas }}</td>
                            <td class="px-6 py-4">
                                @if($anggota->no_hp)
                                    <p class="text-slate-600">{{ $anggota->no_hp }}</p>
                                @else
                                    <p class="text-slate-400 italic text-xs">Belum ada</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" @click="editAnggotaData = { id: {{ $anggota->id }}, nis: '{{ addslashes($anggota->nis) }}', nama: '{{ addslashes($anggota->nama) }}', kelas: '{{ addslashes($anggota->kelas) }}', email: '{{ addslashes($anggota->user->email ?? '') }}', no_hp: '{{ addslashes($anggota->no_hp) }}', url: '{{ route('anggota.update', $anggota->id) }}' }; showModalEditAnggota = true" 
                                       class="w-8 h-8 rounded-md bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" class="inline"
                                          data-confirm="Apakah Anda yakin ingin menghapus {{ $anggota->nama }}? Tindakan ini tidak dapat dibatalkan."
                                          data-confirm-title="Hapus Anggota?"
                                          data-confirm-btn="Ya, Hapus"
                                          data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>'>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 rounded-md bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @if($anggota->user)
                                        @if(!$anggota->user->admin_verified_at)
                                            <form action="{{ route('anggota.verify', $anggota->id) }}" method="POST" class="inline"
                                                  data-confirm="Verifikasi pendaftaran {{ $anggota->nama }}? Sistem akan mengirimkan email verifikasi."
                                                  data-confirm-title="Verifikasi Anggota?"
                                                  data-confirm-btn="Ya, Verifikasi"
                                                  data-confirm-class="bg-amber-500 hover:bg-amber-600"
                                                  data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>
                                                @csrf
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-md bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition" title="Verifikasi Pendaftaran">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </button>
                                            </form>
                                        @elseif(!$anggota->user->email_verified_at)
                                            <form action="{{ route('anggota.resend-welcome', $anggota->id) }}" method="POST" class="inline"
                                                  data-confirm="Kirim ulang email undangan ke {{ $anggota->user->email }}?"
                                                  data-confirm-title="Kirim Ulang Email?"
                                                  data-confirm-btn="Ya, Kirim"
                                                  data-confirm-class="bg-emerald-500 hover:bg-emerald-600"
                                                  data-confirm-icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'>
                                                @csrf
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-md bg-emerald-50 text-emerald-500 flex items-center justify-center hover:bg-emerald-100 transition" title="Kirim Ulang Email Set Password">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data anggota.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>



    {{-- MODAL ANGGOTA --}}
    <div x-data="{ role: 'anggota' }" x-show="showModalAnggota" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModalAnggota" @click="showModalAnggota = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="showModalAnggota" x-transition.scale.origin.bottom class="inline-block w-full max-w-lg px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Daftarkan Anggota
                    </h3>
                    <button @click="showModalAnggota = false" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Role Akun <span class="text-red-500">*</span></label>
                            <select name="role" x-model="role" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                                <option value="anggota">Anggota Biasa</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div x-show="role === 'anggota'">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                            <input type="text" name="nis" :required="role === 'anggota'" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                        </div>
                        <div x-show="role === 'anggota'">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                            <input type="text" name="kelas" :required="role === 'anggota'" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition" placeholder="Sistem akan otomatis mengirim email ke alamat ini.">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP</label>
                            <input type="text" name="no_hp" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm bg-white text-slate-800 outline-none transition">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModalAnggota = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Simpan Anggota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- MODAL EDIT ANGGOTA --}}
        <div x-show="showModalEditAnggota" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModalEditAnggota" @click="showModalEditAnggota = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm"></div>
                <div x-show="showModalEditAnggota" x-transition.scale.origin.bottom class="inline-block w-full max-w-lg px-6 py-6 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl rounded-2xl sm:my-8 sm:align-middle border border-slate-100 relative">
                    <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Anggota
                        </h3>
                        <button @click="showModalEditAnggota = false" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form :action="editAnggotaData.url" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                                <input type="text" name="nis" x-model="editAnggotaData.nis" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" x-model="editAnggotaData.nama" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                                <input type="text" name="kelas" x-model="editAnggotaData.kelas" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" x-model="editAnggotaData.email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP</label>
                                <input type="text" name="no_hp" x-model="editAnggotaData.no_hp" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-white text-slate-800 outline-none transition">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                            <button type="button" @click="showModalEditAnggota = false" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Batal</button>
                            <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                Update Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>