<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama_pelanggan', 'no_telepon'];

    // Satu pelanggan bisa punya banyak transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
