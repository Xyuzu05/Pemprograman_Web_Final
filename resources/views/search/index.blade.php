<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-search"></i> Pencarian Global
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header ringkasan pencarian --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="mb-1 fw-bold">
                                <i class="bi bi-search me-2 text-primary"></i>
                                Hasil Pencarian: "<span class="text-primary">{{ $keyword }}</span>"
                            </h4>
                            <p class="text-muted mb-0">
                                Ditemukan <strong>{{ $totalResults }}</strong> hasil dari semua kategori
                            </p>
                        </div>
                        {{-- Form pencarian ulang --}}
                        <form action="{{ route('search') }}" method="GET" class="d-flex gap-2" style="min-width: 300px;">
                            <input type="text" name="q" class="form-control" placeholder="Cari lagi..." value="{{ $keyword }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Statistik ringkas hasil pencarian --}}
            <div class="row g-3 mb-4">
                @foreach([
                    ['Buku', $results['buku']->count(), 'bi-book-fill', 'primary', '#tab-buku'],
                    ['Anggota', $results['anggota']->count(), 'bi-people-fill', 'success', '#tab-anggota'],
                    ['Transaksi', $results['transaksi']->count(), 'bi-receipt', 'warning', '#tab-transaksi'],
                ] as [$label, $count, $icon, $color, $tab])
                <div class="col-md-4">
                    <div class="card border-{{ $color }} h-100 search-stat-card" data-tab="{{ $tab }}" style="cursor: pointer; transition: all 0.2s ease;">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 bg-{{ $color }} bg-opacity-10" style="width: 50px; height: 50px;">
                                <i class="bi {{ $icon }} fs-4 text-{{ $color }}"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-0 small">{{ $label }}</h6>
                                <h3 class="mb-0 fw-bold">{{ $count }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Tab navigasi --}}
            <ul class="nav nav-pills mb-4 gap-2" id="searchTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab-buku">
                        <i class="bi bi-book"></i> Buku
                        <span class="badge bg-primary rounded-pill">{{ $results['buku']->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab-anggota">
                        <i class="bi bi-people"></i> Anggota
                        <span class="badge bg-success rounded-pill">{{ $results['anggota']->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="tab" href="#tab-transaksi">
                        <i class="bi bi-receipt"></i> Transaksi
                        <span class="badge bg-warning text-dark rounded-pill">{{ $results['transaksi']->count() }}</span>
                    </a>
                </li>
            </ul>

            {{-- Tab content --}}
            <div class="tab-content">

                {{-- ==================== TAB BUKU ==================== --}}
                <div class="tab-pane fade show active" id="tab-buku">
                    @forelse($results['buku'] as $buku)
                    <div class="card mb-3 border-0 shadow-sm search-result-card" style="animation: fadeInUp 0.3s ease {{ $loop->index * 0.05 }}s both;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- Ikon buku --}}
                                <div class="col-auto">
                                    <div class="rounded d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 60px; height: 70px;">
                                        <i class="bi bi-book-fill fs-2 text-primary"></i>
                                    </div>
                                </div>
                                {{-- Info buku --}}
                                <div class="col">
                                    <div class="d-flex align-items-start justify-content-between mb-1">
                                        <div>
                                            <h5 class="mb-1 fw-bold">
                                                <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none text-dark">
                                                    {!! str_ireplace($keyword, '<mark class="px-1 rounded">'.$keyword.'</mark>', e($buku->judul)) !!}
                                                </a>
                                            </h5>
                                            <span class="badge bg-primary me-1">{{ $buku->kategori_rel->nama_kategori ?? $buku->kategori ?? 'Umum' }}</span>
                                            <span class="badge bg-secondary">{{ $buku->kode_buku }}</span>
                                        </div>
                                        <div class="text-end">
                                            {!! $buku->status_stok_badge !!}
                                            <div class="small text-muted mt-1">Stok: {{ $buku->stok }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 text-muted small mt-2">
                                        <span><i class="bi bi-person me-1"></i>{{ $buku->pengarang }}</span>
                                        <span><i class="bi bi-building me-1"></i>{{ $buku->penerbit }}</span>
                                        <span><i class="bi bi-calendar me-1"></i>{{ $buku->tahun_terbit }}</span>
                                        @if($buku->isbn)
                                        <span><i class="bi bi-upc me-1"></i>ISBN: {{ $buku->isbn }}</span>
                                        @endif
                                        <span><i class="bi bi-tag me-1"></i>{{ $buku->harga_format }}</span>
                                    </div>
                                </div>
                                {{-- Tombol aksi --}}
                                <div class="col-auto">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-book fs-1 text-muted"></i>
                            <p class="text-muted mt-3 mb-0">Tidak ada buku yang cocok dengan "<strong>{{ $keyword }}</strong>"</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- ==================== TAB ANGGOTA ==================== --}}
                <div class="tab-pane fade" id="tab-anggota">
                    @forelse($results['anggota'] as $anggota)
                    <div class="card mb-3 border-0 shadow-sm search-result-card" style="animation: fadeInUp 0.3s ease {{ $loop->index * 0.05 }}s both;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- Avatar anggota --}}
                                <div class="col-auto">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width: 55px; height: 55px;">
                                        <i class="bi bi-person-fill fs-3 text-success"></i>
                                    </div>
                                </div>
                                {{-- Info anggota --}}
                                <div class="col">
                                    <h5 class="mb-1 fw-bold">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" class="text-decoration-none text-dark">
                                            {!! str_ireplace($keyword, '<mark class="px-1 rounded">'.$keyword.'</mark>', e($anggota->nama)) !!}
                                        </a>
                                    </h5>
                                    <span class="badge bg-secondary me-1">{{ $anggota->kode_anggota }}</span>
                                    {!! $anggota->status_badge !!}
                                    <div class="d-flex flex-wrap gap-3 text-muted small mt-2">
                                        <span><i class="bi bi-envelope me-1"></i>{{ $anggota->email }}</span>
                                        @if($anggota->telepon)
                                        <span><i class="bi bi-telephone me-1"></i>{{ $anggota->telepon }}</span>
                                        @endif
                                        @if($anggota->jenis_kelamin)
                                        <span><i class="bi bi-gender-ambiguous me-1"></i>{{ $anggota->jenis_kelamin }}</span>
                                        @endif
                                        @if($anggota->tanggal_daftar)
                                        <span><i class="bi bi-calendar-check me-1"></i>Sejak {{ $anggota->tanggal_daftar->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- Tombol aksi --}}
                                <div class="col-auto">
                                    <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-people fs-1 text-muted"></i>
                            <p class="text-muted mt-3 mb-0">Tidak ada anggota yang cocok dengan "<strong>{{ $keyword }}</strong>"</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- ==================== TAB TRANSAKSI ==================== --}}
                <div class="tab-pane fade" id="tab-transaksi">
                    @forelse($results['transaksi'] as $trx)
                    <div class="card mb-3 border-0 shadow-sm search-result-card" style="animation: fadeInUp 0.3s ease {{ $loop->index * 0.05 }}s both;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- Ikon transaksi --}}
                                <div class="col-auto">
                                    <div class="rounded d-flex align-items-center justify-content-center bg-warning bg-opacity-10" style="width: 55px; height: 55px;">
                                        <i class="bi bi-receipt fs-3 text-warning"></i>
                                    </div>
                                </div>
                                {{-- Info transaksi --}}
                                <div class="col">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h5 class="mb-0 fw-bold">{{ $trx->kode_transaksi }}</h5>
                                        {!! $trx->status_badge !!}
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 text-muted small mt-2">
                                        <span><i class="bi bi-person me-1"></i>{{ $trx->anggota->nama ?? '-' }}</span>
                                        <span><i class="bi bi-book me-1"></i>{{ $trx->buku->judul ?? '-' }}</span>
                                        <span><i class="bi bi-calendar me-1"></i>{{ $trx->tanggal_pinjam->format('d M Y') }}</span>
                                        <span><i class="bi bi-calendar-x me-1"></i>Batas: {{ $trx->tanggal_kembali->format('d M Y') }}</span>
                                        @if($trx->denda > 0)
                                        <span class="text-danger fw-semibold"><i class="bi bi-cash me-1"></i>Denda: Rp {{ number_format($trx->denda, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- Tombol aksi --}}
                                <div class="col-auto">
                                    <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-warning text-dark">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-receipt fs-1 text-muted"></i>
                            <p class="text-muted mt-3 mb-0">Tidak ada transaksi yang cocok dengan "<strong>{{ $keyword }}</strong>"</p>
                        </div>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- Custom styles untuk halaman pencarian --}}
    @push('styles')
    <style>
        /* Animasi fade-in untuk setiap card hasil pencarian */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Efek hover pada card hasil pencarian */
        .search-result-card { transition: all 0.2s ease; }
        .search-result-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
        }

        /* Efek hover pada statistik card */
        .search-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.12) !important;
        }

        /* Style nav-pills custom */
        .nav-pills .nav-link {
            border-radius: 50px;
            padding: 8px 20px;
            color: #6c757d;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f8f9fa;
            border-color: #adb5bd;
        }

        /* Highlight style untuk keyword match */
        mark {
            background-color: #fff3cd;
            padding: 1px 4px;
            border-radius: 3px;
        }
    </style>
    @endpush

    {{-- Script interaktif untuk stat card klik ke tab --}}
    @push('scripts')
    <script>
        /* Klik stat card untuk pindah ke tab terkait */
        document.querySelectorAll('.search-stat-card').forEach(card => {
            card.addEventListener('click', function() {
                const tabTarget = this.dataset.tab;
                const tabLink = document.querySelector(`a[href="${tabTarget}"]`);
                if (tabLink) {
                    const tab = new bootstrap.Tab(tabLink);
                    tab.show();
                    tabLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
