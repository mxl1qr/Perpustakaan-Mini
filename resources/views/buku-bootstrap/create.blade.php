<x-bootstrap-layout>
    <x-slot name="header">
        <h2>
            <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Buku Baru
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card card-main">
                <div class="card-body p-4">

                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-medium">Judul Buku</label>
                            <input type="text"
                                   name="judul"
                                   id="judul"
                                   value="{{ old('judul') }}"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   placeholder="Masukkan Judul Buku">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pengarang --}}
                        <div class="mb-3">
                            <label for="pengarang" class="form-label fw-medium">Pengarang</label>
                            <input type="text"
                                   name="pengarang"
                                   id="pengarang"
                                   value="{{ old('pengarang') }}"
                                   class="form-control @error('pengarang') is-invalid @enderror"
                                   placeholder="Nama pengarang">
                            @error('pengarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tahun Terbit --}}
                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label fw-medium">Tahun Terbit</label>
                            <input type="number"
                                   name="tahun_terbit"
                                   id="tahun_terbit"
                                   value="{{ old('tahun_terbit') }}"
                                   class="form-control @error('tahun_terbit') is-invalid @enderror"
                                   placeholder="Contoh: 2023" min="1000" max="9999">
                            @error('tahun_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div class="mb-4">
                            <label for="stok" class="form-label fw-medium">Stok</label>
                            <input type="number"
                                   name="stok"
                                   id="stok"
                                   value="{{ old('stok') }}"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   placeholder="Jumlah stok" min="0">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ url('/buku-bootstrap') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-lg me-1"></i> Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-bootstrap-layout>
