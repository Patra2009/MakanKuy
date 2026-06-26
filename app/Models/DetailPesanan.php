<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans';

    protected $fillable = [
        'pesanan_id', 'menu_id', 'jumlah', 'harga', 'subtotal'
    ];

    /**
     * Get the pesanan that owns the detail.
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Get the menu for the detail.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
