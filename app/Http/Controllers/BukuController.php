<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        $kategoris = Kategori::all();
        
        // Return view dengan data
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoris'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            // Ambil data validated dan set kolom kategori dari relasi kategori_id
            $data = $request->validated();
            $kategori = Kategori::find($data['kategori_id']);
            $data['kategori'] = $kategori ? $kategori->nama_kategori : null;

            // Create buku baru dengan data yang sudah dilengkapi
            Buku::create($data);

            // Redirect dengan success message
            return redirect()->route('buku.index')
                             ->with('success', 'Buku berhasil ditambahkan!');
                         
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view ('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);

            // Ambil data validated dan set kolom kategori dari relasi kategori_id
            $data = $request->validated();
            $kategori = Kategori::find($data['kategori_id']);
            $data['kategori'] = $kategori ? $kategori->nama_kategori : null;

            // Update buku dengan data yang sudah dilengkapi
            $buku->update($data);

            // Redirect dengan success message
            return redirect()->route('buku.show', $buku->id)
                             ->with('success', 'Buku berhasil diupdate!');

        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $judulBuku = $buku->judul;
            
            // Hapus semua transaksi terkait buku ini terlebih dahulu
            $buku->transaksis()->delete();

            // Delete buku
            $buku->delete();
            
            // Redirect dengan success message
            return redirect()->route('buku.index')
                             ->with('success', "Buku '{$judulBuku}' beserta riwayat transaksinya berhasil dihapus!");
                             
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'buku_ids' => 'required|array',
            'buku_ids.*' => 'exists:buku,id',
        ], [
            'buku_ids.required' => 'Pilih minimal satu buku untuk dihapus.',
        ]);

        try {
            $ids = $request->buku_ids;

            // Hapus semua transaksi terkait buku yang akan dihapus
            \App\Models\Transaksi::whereIn('buku_id', $ids)->delete();

            // Hapus buku
            Buku::whereIn('id', $ids)->delete();

            return redirect()->route('buku.index')
                             ->with('success', count($ids) . ' buku beserta riwayat transaksinya berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $bukus = Buku::all();

        $filename = 'buku_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bukus) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Buku', 'Judul', 'Kategori', 'Pengarang',
                'Penerbit', 'Tahun', 'ISBN', 'Harga', 'Stok'
            ]);

            foreach ($bukus as $buku) {
                fputcsv($file, [
                    $buku->kode_buku,
                    $buku->judul,
                    $buku->kategori,
                    $buku->pengarang,
                    $buku->penerbit,
                    $buku->tahun_terbit,
                    $buku->isbn,
                    $buku->harga,
                    $buku->stok,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function filterKategori($kategori) {
        $bukus = Buku::where ('kategori', $kategori)->latest()->get();

        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        return view ('buku.index', compact(
            'bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis'
        ));
    }

        /**
     * Mencari dan memfilter data buku secara advanced.
     */
    public function search(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('pengarang', 'like', "%{$keyword}%")
                  ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan == 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        // Filter berdasarkan range harga
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        $bukus = $query->latest()->get();

        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        $kategoris = Kategori::all();

        return view('buku.index', compact(
            'bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis', 'kategoris'
        ));
    }
}
