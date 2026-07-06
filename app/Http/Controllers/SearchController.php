<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;
 
class SearchController extends Controller
{
    /**
     * Menampilkan hasil pencarian global berdasarkan keyword.
     * Mencari data dari tabel buku, anggota, dan transaksi secara bersamaan.
     * Menghitung total hasil dari semua kategori pencarian.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        /* Ambil keyword pencarian dari query string */
        $keyword = $request->input('q');
        $results = ['buku' => collect(), 'anggota' => collect(), 'transaksi' => collect()];
 
        if ($keyword) {
            /* Pencarian buku berdasarkan judul, pengarang, isbn, dan kode_buku dengan relasi kategori */
            $results['buku'] = Buku::with('kategori_rel')
                                   ->where('judul', 'LIKE', "%{$keyword}%")
                                   ->orWhere('pengarang', 'LIKE', "%{$keyword}%")
                                   ->orWhere('isbn', 'LIKE', "%{$keyword}%")
                                   ->orWhere('kode_buku', 'LIKE', "%{$keyword}%")
                                   ->orWhere('penerbit', 'LIKE', "%{$keyword}%")
                                   ->get();
 
            /* Pencarian anggota berdasarkan nama, email, kode_anggota, dan telepon */
            $results['anggota'] = Anggota::where('nama', 'LIKE', "%{$keyword}%")
                                         ->orWhere('email', 'LIKE', "%{$keyword}%")
                                         ->orWhere('kode_anggota', 'LIKE', "%{$keyword}%")
                                         ->orWhere('telepon', 'LIKE', "%{$keyword}%")
                                         ->get();
 
            /* Pencarian transaksi berdasarkan kode transaksi, nama anggota, atau judul buku */
            $results['transaksi'] = Transaksi::with(['anggota', 'buku'])
                ->where('kode_transaksi', 'LIKE', "%{$keyword}%")
                ->orWhereHas('anggota', fn($q) => $q->where('nama', 'LIKE', "%{$keyword}%"))
                ->orWhereHas('buku', fn($q) => $q->where('judul', 'LIKE', "%{$keyword}%"))
                ->get();
        }

        /* Hitung total hasil pencarian dari semua kategori */
        $totalResults = $results['buku']->count() + $results['anggota']->count() + $results['transaksi']->count();
 
        return view('search.index', compact('keyword', 'results', 'totalResults'));
    }
}