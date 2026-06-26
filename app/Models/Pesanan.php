<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'user_id', 'total_harga', 'status', 'metode_pembayaran', 'alamat_pengiriman'
    ];

    /**
     * Get the user that owns the pesanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get detail pesanans for the pesanan.
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    /**
     * Generate kode pesanan.
     */
    public function getKodePesananAttribute(): string
    {
        return 'ORD-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
