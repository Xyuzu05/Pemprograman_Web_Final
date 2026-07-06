<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Form --}}
            <div class="card mb-4" id="filter-section">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.laporan') }}" method="GET">
                        <div class="row">
                            {{-- Filter Tanggal Dari --}}
                            <div class="col-md-3 mb-3">
                                <label for="dari" class="form-label">Dari Tanggal</label>
                                <input type="date" name="dari" id="dari" class="form-control"
                                       value="{{ request('dari') }}">
                            </div>

                            {{-- Filter Tanggal Sampai --}}
                            <div class="col-md-3 mb-3">
                                <label for="sampai" class="form-label">Sampai Tanggal</label>
                                <input type="date" name="sampai" id="sampai" class="form-control"
                                       value="{{ request('sampai') }}">
                            </div>

                            {{-- Filter Status --}}
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>

                            {{-- Filter Anggota --}}
                            <div class="col-md-3 mb-3">
                                <label for="anggota_id" class="form-label">Anggota</label>
                                <select name="anggota_id" id="anggota_id" class="form-select">
                                    <option value="">Semua Anggota</option>
                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                            {{ $anggota->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route('transaksi.laporan') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                            <button type="button" class="btn btn-danger ms-auto" onclick="cetakPDF()">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h6 class="text-muted">Total Transaksi</h6>
                            <h2>{{ $transaksis->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h6 class="text-muted">Total Denda</h6>
                            <h2 class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Laporan --}}
            <div class="card" id="laporan-table">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-table"></i> Data Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Tgl Dikembalikan</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                    <td>{{ $transaksi->anggota->nama }}</td>
                                    <td>{{ $transaksi->buku->judul }}</td>
                                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                    <td>{{ $transaksi->tanggal_dikembalikan ? $transaksi->tanggal_dikembalikan->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($transaksi->status == 'Dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Tidak ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($transaksis->count() > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="8" class="text-end">Total Denda:</th>
                                    <th class="text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        // Fungsi export PDF menggunakan window.print
        function cetakPDF() {
            // Sembunyikan elemen yang tidak perlu dicetak
            document.getElementById('filter-section').style.display = 'none';

            window.print();

            // Tampilkan kembali setelah print
            document.getElementById('filter-section').style.display = 'block';
        }
    </script>
    @endpush
</x-app-layout>
