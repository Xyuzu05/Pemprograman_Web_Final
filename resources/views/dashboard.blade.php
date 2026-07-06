<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SECTION 1: Statistics Cards (8 kartu dari ketentuan) --}}
            <div class="row g-3 mb-4">
                @foreach([
                    ['Total Buku', $stats['total_buku'], 'bi-book', 'primary'],
                    ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'success'],
                    ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'info'],
                    ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'danger'],
                    ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'warning'],
                    ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'secondary'],
                    ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'dark'],
                    ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'danger'],
                ] as [$label, $value, $icon, $color])
                <div class="col-xl-3 col-md-6">
                    <div class="card border-{{ $color }} h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi {{ $icon }} fs-1 text-{{ $color }} me-3"></i>
                            <div>
                                <h6 class="text-muted mb-1">{{ $label }}</h6>
                                <h4 class="mb-0">{{ $value }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- SECTION 2: Charts (Line + Pie dari ketentuan) --}}
            <div class="row mb-4">
                {{-- Line Chart: Transaksi 6 Bulan Terakhir --}}
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-graph-up me-1"></i> Transaksi 6 Bulan Terakhir
                        </div>
                        <div class="card-body">
                            <canvas id="chartTransaksi" height="100"></canvas>
                        </div>
                    </div>
                </div>
                {{-- Pie Chart: Top 5 Buku Populer --}}
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-pie-chart me-1"></i> Top 5 Buku Populer
                        </div>
                        <div class="card-body">
                            <canvas id="chartBuku" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Row 2: Bar Chart + Donut Chart --}}
            <div class="row mb-4">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-bar-chart me-1"></i> Top 5 Buku Terpopuler
                        </div>
                        <div class="card-body">
                            <canvas id="chartBar" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-circle-half me-1"></i> Status Transaksi
                        </div>
                        <div class="card-body">
                            <canvas id="chartDonut" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Buku Terlambat (dari dashboard lama) --}}
            @if($transaksiTerlambat->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-red-500">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-red-600">
                            <svg class="inline h-6 w-6 text-red-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Buku Terlambat
                        </h3>
                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-red-100 text-red-800">
                            {{ $transaksiTerlambat->count() }} transaksi
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Terlambat</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Denda Sementara</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaksiTerlambat as $tl)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $tl->anggota->nama }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $tl->buku->judul }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $tl->terlambat_format }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm font-semibold text-red-600">
                                        Rp {{ number_format($tl->terlambat * 5000, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('transaksi.show', $tl->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            Detail →
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- SECTION 4: Quick Actions (dari dashboard lama) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('buku.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="font-medium text-blue-900">Tambah Buku</span>
                        </a>
                        <a href="{{ route('anggota.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="font-medium text-green-900">Tambah Anggota</span>
                        </a>
                        <a href="{{ route('transaksi.create') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <svg class="h-8 w-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span class="font-medium text-yellow-900">Pinjam Buku</span>
                        </a>
                        <a href="{{ route('transaksi.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <svg class="h-8 w-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="font-medium text-purple-900">Lihat Transaksi</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- SECTION 5: Recent Transactions (dari ketentuan) --}}
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-1"></i> Transaksi Terbaru
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransaksi as $trx)
                            <tr>
                                <td>{{ $trx->kode_transaksi }}</td>
                                <td>{{ $trx->anggota->nama }}</td>
                                <td>{{ $trx->buku->judul }}</td>
                                <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning' : 'success' }}">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js Scripts --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Line chart — Transaksi 6 bulan terakhir
    new Chart(document.getElementById('chartTransaksi'), {
        type: 'line',
        data: {
            labels: @json($chartData->pluck('bulan')),
            datasets: [
                { label: 'Peminjaman', data: @json($chartData->pluck('pinjam')),
                  borderColor: '#0d6efd', tension: 0.3 },
                { label: 'Pengembalian', data: @json($chartData->pluck('kembali')),
                  borderColor: '#198754', tension: 0.3 }
            ]
        },
        options: { responsive: true }
    });

    // Pie chart — Buku Populer
    new Chart(document.getElementById('chartBuku'), {
        type: 'pie',
        data: {
            labels: @json($bukuPopuler->pluck('judul')),
            datasets: [{
                data: @json($bukuPopuler->pluck('transaksis_count')),
                backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Bar chart — Top 5 Buku Terpopuler
    new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {
            labels: @json($bukuPopuler->pluck('judul')),
            datasets: [{
                label: 'Jumlah Dipinjam',
                data: @json($bukuPopuler->pluck('transaksis_count')),
                backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1']
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Donut chart — Status Transaksi
    new Chart(document.getElementById('chartDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Dipinjam', 'Dikembalikan'],
            datasets: [{
                data: [@json($statusChart['dipinjam']), @json($statusChart['dikembalikan'])],
                backgroundColor: ['#ffc107', '#198754']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
    </script>
    @endpush
</x-app-layout>