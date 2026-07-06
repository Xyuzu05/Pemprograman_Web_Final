<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="bi bi-tags"></i> Kategori Buku</h1>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                                        <td>{{ $kategori->deskripsi ?? '-' }}</td>
                                        <td><span class="badge bg-info">{{ $kategori->bukus_count }}</span></td>
                                        <td>
                                            <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini? Buku terkait mungkin akan kehilangan kategori.')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">Belum ada kategori.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
