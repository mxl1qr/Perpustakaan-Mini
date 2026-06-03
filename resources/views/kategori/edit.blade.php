<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_kategori') border-red-500 @enderror">
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition text-center">
                            Update
                        </button>
                        <a href="{{ route('kategori.index') }}"
                           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
