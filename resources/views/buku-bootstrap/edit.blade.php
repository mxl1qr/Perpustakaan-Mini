<x-bootstrap-layout>
    <x-slot name="header">
        <h2>
            <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Buku
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card card-main">
                <div class="card-body p-4">

                    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-medium">Judul Buku</label>
                            <input type="text"
                                   name="judul"
                                   id="judul"
                                   value="{{ old('judul', $buku->judul) }}"
                                   class="form-control @error('judul') is-invalid @enderror">
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
                                   value="{{ old('pengarang', $buku->pengarang) }}"
                                   class="form-control @error('pengarang') is-invalid @enderror">
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
                                   value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                   class="form-control @error('tahun_terbit') is-invalid @enderror"
                                   min="1000" max="9999">
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
                                   value="{{ old('stok', $buku->stok) }}"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   min="0">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-lg me-1"></i> Update
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
