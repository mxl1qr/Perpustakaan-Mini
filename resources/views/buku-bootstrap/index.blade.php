<x-bootstrap-layout>
    <x-slot name="header">
        <h2>
            <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>Daftar Buku Perpustakaan
        </h2>
    </x-slot>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-main">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-database me-1 text-secondary"></i> Data Buku
                </h5>
                <a href="{{ url('/buku-bootstrap/create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Buku
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px" class="text-center">No</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th class="text-center" style="width: 130px">Tahun Terbit</th>
                            <th class="text-center" style="width: 80px">Stok</th>
                            <th class="text-center" style="width: 160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukus as $index => $buku)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $buku->judul }}</td>
                                <td>{{ $buku->pengarang }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">{{ $buku->tahun_terbit }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $buku->stok }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/buku-bootstrap/' . $buku->id . '/edit') }}"
                                       class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin mau hapus?')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
