<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data pelanggan
        Pelanggan::insert([
            ['nama_pelanggan' => 'Andi Saputra',    'no_telepon' => '081234567890', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pelanggan' => 'Budi Santoso',     'no_telepon' => '082345678901', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pelanggan' => 'Citra Dewi',       'no_telepon' => '083456789012', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pelanggan' => 'Dian Permata',     'no_telepon' => '084567890123', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pelanggan' => 'Eko Prasetyo',     'no_telepon' => null,           'created_at' => now(), 'updated_at' => now()],
        ]);

        // Data barang
        Barang::insert([
            ['nama_barang' => 'Pensil 2B',          'harga_satuan' => 3000,     'stok' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['nama_barang' => 'Buku Tulis',         'harga_satuan' => 5000,     'stok' => 80,  'created_at' => now(), 'updated_at' => now()],
            ['nama_barang' => 'Penggaris 30cm',     'harga_satuan' => 8000,     'stok' => 50,  'created_at' => now(), 'updated_at' => now()],
            ['nama_barang' => 'Tas Sekolah',        'harga_satuan' => 150000,   'stok' => 25,  'created_at' => now(), 'updated_at' => now()],
            ['nama_barang' => 'Sepatu Olahraga',    'harga_satuan' => 350000,   'stok' => 15,  'created_at' => now(), 'updated_at' => now()],
            ['nama_barang' => 'Botol Minum',        'harga_satuan' => 25000,    'stok' => 40,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
