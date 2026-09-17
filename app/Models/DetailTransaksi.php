<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'subtotal'];

    // Detail ini milik satu transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Detail ini merujuk satu barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
