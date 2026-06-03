<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catat Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-4 sm:p-6">

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Anggota --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anggota</label>
                        <select name="anggota_id"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('anggota_id') border-red-500 @enderror">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nis }} — {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilih Buku --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buku</label>
                        <select name="buku_id"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('buku_id') border-red-500 @enderror">
                            <option value="">-- Pilih Buku --</option>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Kembali Rencana --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali_rencana"
                               value="{{ old('tgl_kembali_rencana', now()->addDays(14)->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               max="{{ now()->addDays(14)->format('Y-m-d') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tgl_kembali_rencana') border-red-500 @enderror">
                        <p class="text-xs text-gray-400 mt-1">Default 14 hari dari sekarang. Maksimal durasi pinjam adalah 14 hari.</p>
                        @error('tgl_kembali_rencana')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition text-center">
                            Pinjam Buku
                        </button>
                        <a href="{{ route('peminjaman.index') }}"
                           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
