<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Kategori</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="bi bi-tag"></i> Kategori: {{ $kategori->nama_kategori }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Deskripsi:</strong> {{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    <p><strong>Jumlah Buku:</strong> <span class="badge bg-primary">{{ $kategori->bukus_count }}</span></p>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <h4>Buku dalam kategori ini:</h4>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Buku</th>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bukus as $buku)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $buku->kode_buku }}</code></td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->pengarang }}</td>
                                    <td>{{ $buku->stok }}</td>
                                    <td>
                                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">Belum ada buku di kategori ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
