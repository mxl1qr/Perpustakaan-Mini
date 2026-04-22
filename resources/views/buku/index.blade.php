<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-x1 text-gray-800 leading-tight">
            Daftar Buku Perpustakaan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7x1 mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Data Buku</h3>
                    <a href="{{ route('buku.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                        + Tambah Buku
                    </a>
                </div>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Judul</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Pengarang</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Tahun Terbit</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Stok</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data buku dari controller --}}
                        @forelse ($bukus as $index => $buku)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $buku->judul }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $buku->pengarang }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $buku->tahun_terbit }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $buku->stok }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('buku.edit', $buku->id) }}"
                                        class="bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500">Edit</a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-400">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>