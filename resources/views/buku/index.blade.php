<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="fw-bold">
            <i class="bi bi-book"></i> Daftar Koleksi Buku
        </h2>
        <p class="text-muted mb-0">Kelola informasi buku dan lakukan pencarian data dengan mudah.</p>
    </div>
    <a href="{{ route('buku.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
</div>

{{-- Pencarian & Filter --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header text-white" style="background: linear-gradient(135deg, #e74c3c, #e67e22);">
        <h6 class="mb-0"><i class="bi bi-search"></i> Pencarian & Filter</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kata Kunci</label>
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Cari judul atau pengarang..."
                           value="{{ request('keyword') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Buku --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bukus as $buku)
                        <tr>
                            <td><code class="text-danger">{{ $buku->kode_buku }}</code></td>
                            <td><strong>{{ $buku->judul }}</strong></td>
                            <td>{{ $buku->pengarang }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $buku->kategori_rel->nama_kategori ?? $buku->kategori ?? 'Umum' }}</span>
                            </td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>
                                @if ($buku->stok > 0)
                                    <span class="badge bg-success">{{ $buku->stok }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-judul="{{ $buku->judul }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <i class="bi bi-info-circle"></i> Tidak ada data buku
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // SweetAlert confirmation untuk delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
        </div>
    </div>
</x-app-layout>