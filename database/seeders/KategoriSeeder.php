<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori_list = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi' => 'Buku pemrograman dan coding',
                'icon' => 'code-slash',
                'warna' => 'primary',
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi' => 'Buku tentang basis data',
                'icon' => 'database',
                'warna' => 'success',
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi' => 'Buku desain web',
                'icon' => 'palette',
                'warna' => 'info',
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi' => 'Buku jaringan komputer',
                'icon' => 'wifi',
                'warna' => 'warning',
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi' => 'Buku ilmu data',
                'icon' => 'graph-up',
                'warna' => 'danger',
            ],
        ];

        foreach ($kategori_list as $kategori) {
            Kategori::create($kategori);
        }
    }
}
