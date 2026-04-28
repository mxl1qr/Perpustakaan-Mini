<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Buku Perpustakaan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
                    <h3 class="text-lg font-semibold">Data Buku</h3>
                    <a href="{{ route('buku.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded text-center text-sm hover:bg-blue-600 transition">
                        + Tambah Buku
                    </a>
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden sm:block overflow-x-auto">
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
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('buku.edit', $buku->id) }}"
                                                class="bg-yellow-400 text-white px-3 py-1 rounded text-xs hover:bg-yellow-500 transition">Edit</a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                                            </form>
                                        </div>
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

                {{-- Mobile Card View --}}
                <div class="sm:hidden space-y-3">
                    @forelse ($bukus as $index => $buku)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $buku->judul }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $buku->pengarang }}</p>
                                </div>
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 shrink-0">
                                    #{{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                                <span>📅 {{ $buku->tahun_terbit }}</span>
                                <span>📦 Stok: {{ $buku->stok }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('buku.edit', $buku->id) }}"
                                    class="flex-1 text-center bg-yellow-400 text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-yellow-500 transition">
                                    Edit
                                </a>
                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-500 text-white px-3 py-1.5 rounded text-xs font-medium hover:bg-red-600 transition"
                                        onclick="return confirm('Yakin mau hapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            Belum ada data buku.
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </div>

</x-app-layout>