<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
 
class Transaksi extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'keterangan',
    ];
 
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
    ];
 
    // Relationship ke Anggota (belongsTo)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
 
    // Relationship ke Buku (belongsTo)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
 
    // Accessor untuk durasi peminjaman (hari)
    public function getDurasiPeminjamanAttribute()
    {
        if ($this->tanggal_dikembalikan) {
            return $this->tanggal_pinjam->diffInDays($this->tanggal_dikembalikan);
        }
        return $this->tanggal_pinjam->diffInDays(now());
    }
    
    // Accessor untuk cek terlambat (jumlah hari bulat)
    public function getTerlambatAttribute()
    {
        if ($this->status == 'Dikembalikan') {
            if ($this->tanggal_dikembalikan > $this->tanggal_kembali) {
                return intval($this->tanggal_kembali->diffInDays($this->tanggal_dikembalikan));
            }
            return 0;
        }

        if (now() > $this->tanggal_kembali) {
            return intval($this->tanggal_kembali->diffInDays(now()));
        }

        return 0;
    }

    // Accessor untuk format keterlambatan dalam bentuk "X hari Y jam Z menit"
    public function getTerlambatFormatAttribute()
    {
        if ($this->status == 'Dikembalikan') {
            if ($this->tanggal_dikembalikan > $this->tanggal_kembali) {
                $diff = $this->tanggal_kembali->diff($this->tanggal_dikembalikan);
            } else {
                return 'Tepat waktu';
            }
        } elseif (now() > $this->tanggal_kembali) {
            $diff = $this->tanggal_kembali->diff(now());
        } else {
            return 'Belum terlambat';
        }
    
        $parts = [];
        if ($diff->d > 0 || $diff->m > 0 || $diff->y > 0) {
            $totalHari = ($diff->y * 365) + ($diff->m * 30) + $diff->d;
            $parts[] = $totalHari . ' hari';
        }
        if ($diff->h > 0) {
            $parts[] = $diff->h . ' jam';
        }
        if ($diff->i > 0) {
            $parts[] = $diff->i . ' menit';
        }
    
        return !empty($parts) ? implode(' ', $parts) : '0 menit';
    }
 
    // Accessor untuk status badge HTML
    public function getStatusBadgeAttribute()
    {
        return $this->status == 'Dipinjam' 
            ? '<span class="badge bg-warning text-dark">Dipinjam</span>'
            : '<span class="badge bg-success">Dikembalikan</span>';
    }
}
