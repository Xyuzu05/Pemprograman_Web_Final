<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if($transaksi->status == 'Dipinjam' && now() > $transaksi->tanggal_kembali)
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>PERINGATAN!</strong> Buku ini sudah terlambat dikembalikan
                            <strong>{{ $transaksi->terlambat_format }}</strong>.
                            Denda sementara: <strong>Rp {{ number_format($transaksi->terlambat * 5000, 0, ',', '.') }}</strong>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bi bi-receipt"></i>
                                Detail Transaksi - {{ $transaksi->kode_transaksi }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Kode Transaksi</th>
                                    <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                </tr>
                                <tr>
                                    <th>Anggota</th>
                                    <td>{{ $transaksi->anggota->nama }} ({{ $transaksi->anggota->kode_anggota }})</td>
                                </tr>
                                <tr>
                                    <th>Buku</th>
                                    <td>{{ $transaksi->buku->judul }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Harus Kembali</th>
                                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($transaksi->status == 'Dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>

                                @if($transaksi->status == 'Dikembalikan')
                                <tr>
                                    <th>Tanggal Dikembalikan</th>
                                    <td>{{ $transaksi->tanggal_dikembalikan->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Keterlambatan</th>
                                    <td>
                                        @if($transaksi->terlambat > 0)
                                            <span class="text-danger">{{ $transaksi->terlambat_format }}</span>
                                        @else
                                            <span class="text-success">Tepat waktu</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Denda</th>
                                    <td>
                                        @if($transaksi->denda > 0)
                                            <span class="text-danger fw-bold">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-success">Rp 0</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        @if($transaksi->status == 'Dipinjam')
                            <button type="button" class="btn btn-success" id="btn-kembalikan">
                                <i class="bi bi-arrow-return-left"></i> Kembalikan Buku
                            </button>
                        
                            <form id="form-kembalikan" action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                        @else
                            @if($transaksi->tanggal_dikembalikan <= $transaksi->tanggal_kembali)
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle"></i> Dikembalikan tepat waktu pada
                                    {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> Terlambat dikembalikan!
                                    Denda: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert konfirmasi pengembalian --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('btn-kembalikan')?.addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: 'Apakah Anda yakin ingin mengembalikan buku ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-kembalikan').submit();
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
