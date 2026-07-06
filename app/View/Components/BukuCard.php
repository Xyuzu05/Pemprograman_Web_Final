<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BukuCard extends Component
{
    public $buku;
    public $showActions;

    /**
     * Membuat instance komponen BukuCard.
     * Menerima object buku dan opsi untuk menampilkan tombol aksi.
     *
     * @param object $buku Object data buku yang akan ditampilkan
     * @param bool $showActions Toggle tampil/sembunyi tombol Detail & Edit
     * @return void
     */
    public function __construct($buku, $showActions = true)
    {
        $this->buku = $buku;
        $this->showActions = $showActions;
    }

    /**
     * Merender view yang merepresentasikan komponen BukuCard.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.buku-card');
    }
}
