<div class="card border-0 shadow-sm h-100" style="background-color: #ffffff;">
    <div class="card-body d-flex flex-column p-4">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center justify-content-center text-white fw-bold rounded shadow-sm"
                 style="width: 50px; height: 70px; background-color: #0d6efd; font-size: 1.25rem;">
                {{ strtoupper(substr($buku->judul, 0, 1)) }}
            </div>
            <span class="badge" style="background-color: #6c757d; font-weight: 500; padding: 0.5em 0.8em;">
                {{ $buku->kategori ?? 'Umum' }}
            </span>
        </div>

        <h5 class="fw-bold text-dark mb-1">{{ $buku->judul }}</h5>
        <small class="text-muted d-block mb-3">Pengarang: {{ $buku->pengarang }}</small>

        <div class="flex-grow-1"></div>

        <div class="p-3 rounded mb-3" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Harga</span>
                <span class="fw-bold text-dark">{{ $buku->harga_format }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted" style="font-size: 0.85rem;">Stok</span>
                <span class="fw-bold text-dark">{{ $buku->stok }} Pcs</span>
            </div>
            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                <span class="text-muted" style="font-size: 0.85rem;">Status</span>
                <div>{!! $buku->status_stok_badge !!}</div>
            </div>
        </div>

        @if($showActions)
            <div class="d-flex gap-2 mt-auto">
                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-primary btn-sm flex-fill" style="border-width: 2px;">
                    Detail
                </a>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-outline-secondary btn-sm flex-fill" style="border-width: 2px;">
                    Edit
                </a>
            </div>
        @endif

    </div>
</div>
