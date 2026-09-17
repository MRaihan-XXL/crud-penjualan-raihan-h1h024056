<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'pelanggan_id', 'tanggal', 'total'];

    // Satu transaksi milik satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Satu transaksi punya banyak detail item
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
