@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $keyword)

@section('content')
    <h1 class="mb-4">Hasil Pencarian: <span class="text-primary">{{ $keyword }}</span></h1>

    @if (count($hasil) > 0)
    <div class="row">
        @foreach ($hasil as $kategori)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $kategori['nama'] }}</h5>
                    <p class="card-text">{{ $kategori['deskripsi'] }}</p>
                    <p class="card-text"><strong>Jumlah Buku:</strong> {{ $kategori['jumlah_buku'] }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-warning">
        Kategori dengan keyword "<strong>{{ $keyword }}</strong>" tidak ditemukan.
    </div>
    @endif

    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
@endsection
