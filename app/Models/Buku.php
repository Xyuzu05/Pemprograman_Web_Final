<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'buku';

    /**
     * Boot method untuk mendaftarkan event model.
     * Menghapus semua transaksi terkait saat buku dihapus.
     */
    protected static function boot()
    {
        parent::boot();

        // Event deleting: hapus semua transaksi terkait sebelum buku dihapus
        static::deleting(function ($buku) {
            $buku->transaksis()->delete();
        });
    }
 
    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori',
        'kategori_id',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'harga',
        'stok',
        'deskripsi',
        'bahasa',
    ];
 
    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];
 
    /**
     * Accessor untuk format harga.
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
 
    /**
     * Accessor untuk status ketersediaan.
     */
    public function getTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }
 
    /**
     * Scope untuk filter buku tersedia.
     */
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
 
    /**
     * Scope untuk filter berdasarkan kategori.
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

        /**
     * Accessor untuk status stok dalam bentuk badge HTML.
     */
    public function getStatusStokBadgeAttribute(): string
    {
        // TODO: Implement logic
        if ($this->stok == 0) {
            return '<span class="badge bg-danger">Habis</span>';
        } elseif ($this->stok >= 1 && $this->stok <= 5) {
            return '<span class="badge bg-warning">Menipis</span>';
        } elseif ($this->stok >= 6 && $this->stok <= 15) {
            return '<span class="badge bg-info">Sedang</span>';
        } else {
            return '<span class="badge bg-success">Aman</span>';
        }
    }

    /**
     * Accessor untuk label tahun buku.
     */
    public function getTahunLabelAttribute(): string
    {
        if ($this->tahun_terbit >= 2024) {
            return 'Buku Baru';
        } else {
            return 'Buku Lama';
        }
    }

    /**
     * Scope untuk filter buku dengan stok menipis.
     */
    public function scopeStokMenipis($query)
    {
        // TODO: Implement
        return $query->where('stok', '<', 5);
    }

    /**
     * Scope untuk filter buku berdasarkan range harga.
     */
    public function scopeHargaRange($query, $min, $max)
    {
        return $query->whereBetween('harga', [$min, $max]);
    }

    /**
     * Scope untuk filter buku terbaru.
     */
    public function scopeTerbaru($query)
    {
        return $query->where('tahun_terbit', '>=', 2024);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function kategori_rel()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
