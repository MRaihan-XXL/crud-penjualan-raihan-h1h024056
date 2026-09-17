# Naskah Video Penjelasan — Sistem Penjualan Laravel CRUD

**Nama:** Muhammad Raihan  
**NIM:** H1H024056  
**Paket Soal:** 6 — Sistem Manajemen Transaksi Penjualan Sederhana

---

## BAGIAN 1: Pembukaan (±1 menit)

Halo, nama saya Muhammad Raihan, NIM H1H024056. Saya mengerjakan Paket Soal Nomor 6, yaitu Sistem Manajemen Transaksi Penjualan Sederhana. Sistem ini dibangun menggunakan Laravel 13 dengan Blade Template murni.

---

## BAGIAN 2: Penjelasan Studi Kasus & Fitur (±2 menit)

Sistem ini mengelola data transaksi penjualan dengan fitur-fitur sebagai berikut:

**CRUD Dasar:**
- Menambah, melihat, mengubah, dan menghapus data pelanggan
- Menambah, melihat, mengubah, dan menghapus data barang
- Menambah, melihat, mengubah, dan menghapus data transaksi beserta itemnya

**Tantangan Khusus:**
1. Perhitungan otomatis subtotal dan total transaksi — subtotal dihitung dari jumlah beli dikalikan harga satuan, total dijumlahkan dari seluruh subtotal di dalam satu transaksi. Logika ini dijalankan di Controller.
2. Validasi stok barang — jumlah beli tidak boleh melebihi stok yang tersedia. Jika stok tidak cukup, sistem akan menampilkan pesan error.
3. Halaman rekap penjualan per hari — menampilkan ringkasan total penjualan yang dikelompokkan berdasarkan tanggal.

---

## BAGIAN 3: Struktur Project Laravel (±2 menit)

Struktur folder yang saya gunakan:

```
app/Http/Controllers/
  - PelangganController.php   → CRUD pelanggan
  - BarangController.php      → CRUD barang
  - TransaksiController.php   → CRUD transaksi + rekap
  - HomeController.php        → halaman utama

app/Models/
  - Pelanggan.php
  - Barang.php
  - Transaksi.php
  - DetailTransaksi.php

resources/views/
  - layouts/app.blade.php     → layout utama
  - home.blade.php
  - pelanggan/                → index, create, edit, show
  - barang/                   → index, create, edit, show
  - transaksi/                → index, create, edit, show, rekap

routes/web.php                → route resource untuk semua
database/migrations/          → 4 migration
database/seeders/             → data contoh
```

---

## BAGIAN 4: Penjelasan Migration & Struktur Tabel (±2 menit)

Terdapat 4 tabel utama yang saling berelasi:

1. **pelanggan** — menyimpan data nama dan nomor telepon pelanggan
2. **barang** — menyimpan nama barang, harga satuan, dan stok
3. **transaksi** — tabel header transaksi, berisi kode transaksi, pelanggan_id (foreign key), tanggal, dan total
4. **detail_transaksi** — tabel detail/item, berisi transaksi_id, barang_id, jumlah, dan subtotal

Relasi:
- transaksi → belongsTo → pelanggan (satu transaksi milik satu pelanggan)
- detail_transaksi → belongsTo → transaksi (satu detail milik satu transaksi)
- detail_transaksi → belongsTo → barang (satu detail merujuk satu barang)

*(Tampilkan file migration di layar)*

---

## BAGIAN 5: Penjelasan Model & Relasi (±2 menit)

Di file **Pelanggan.php**, saya mendefinisikan:
- `$table = 'pelanggan'` karena Laravel default mencari tabel jamak
- relasi `hasMany` ke Transaksi

Di file **Barang.php**:
- relasi `hasMany` ke DetailTransaksi

Di file **Transaksi.php**:
- `belongsTo` Pelanggan — untuk menampilkan nama pelanggan
- `hasMany` DetailTransaksi — untuk mengambil semua item

Di file **DetailTransaksi.php**:
- `belongsTo` Transaksi
- `belongsTo` Barang — untuk menampilkan nama barang

*(Tampilkan file model di layar)*

---

## BAGIAN 6: Penjelasan Controller & Logika (±4 menit)

### PelangganController & BarangController
Kedua controller ini berisi CRUD dasar: index, create, store, show, edit, update, destroy. Tidak ada logika khusus — hanya validasi input dengan `$request->validate()`.

### TransaksiController — ini yang paling penting

**Metode store() — Simpan Transaksi:**

1. Validasi input dari form (pelanggan, tanggal, array item barang dan jumlah)
2. Loop setiap item:
   - Cari barang berdasarkan ID
   - **Validasi stok**: jika jumlah beli lebih besar dari stok, kembalikan error
   - **Hitung subtotal** = harga_satuan × jumlah
   - Tambahkan ke total transaksi
3. Simpan dalam DB::transaction supaya aman:
   - Buat record transaksi header
   - Buat record detail transaksi untuk setiap item
   - Kurangi stok barang
4. Redirect ke halaman daftar transaksi

**Metode destroy() — Hapus Transaksi:**
Sebelum menghapus, stok barang dikembalikan dulu agar data stok tetap akurat.

**Metode rekap() — Laporan Harian:**
Menggunakan query grouping:
```php
Transaksi::select('tanggal', DB::raw('COUNT(*) as jumlah_transaksi'), DB::raw('SUM(total) as total_penjualan'))
    ->groupBy('tanggal')
    ->orderBy('tanggal', 'desc')
    ->get();
```

*(Tampilkan file controller di layar, fokus ke logika store dan rekap)*

---

## BAGIAN 7: Penjelasan Blade View (±3 menit)

### Layout (layouts/app.blade.php)
Menggunakan Bootstrap 5 CDN untuk styling. Berisi navbar dengan link ke Pelanggan, Barang, Transaksi, dan Rekap. Semua halaman extends layout ini.

### Form Transaksi (transaksi/create.blade.php)
Bagian paling penting di view ini:
- Dropdown pelanggan dan input tanggal
- Bagian item transaksi yang bisa ditambah/dihapus secara dinamis pakai JavaScript
- Setiap kali jumlah diubah, JavaScript menghitung subtotal otomatis berdasarkan harga satuan
- Total juga dihitung ulang otomatis

*(Tampilkan form transaksi, demonstrasi dynamic item)*

### Halaman Rekap (transaksi/rekap.blade.php)
Tabel sederhana yang menampilkan tanggal, jumlah transaksi, dan total penjualan per hari. Ada grand total di bagian bawah.

---

## BAGIAN 8: Demo Aplikasi (±5 menit)

### Demo 1: Data Pelanggan
*(Buka browser → localhost:8888 → Pelanggan)*
- Tampilkan daftar pelanggan
- Tambah pelanggan baru
- Edit data pelanggan
- Hapus pelanggan (dengan konfirmasi)

### Demo 2: Data Barang
*(Buka halaman Barang)*
- Tampilkan daftar barang beserta stok
- Tambah barang baru
- Edit barang

### Demo 3: Transaksi
*(Buka halaman Transaksi → Tambah Transaksi)*
- Pilih pelanggan
- Pilih barang, masukkan jumlah → subtotal terhitung otomatis
- Tambah item lain → total terhitung otomatis
- Submit transaksi
- Lihat detail transaksi

### Demo 4: Validasi Stok
- Coba beli barang dengan jumlah melebihi stok → muncul pesan error

### Demo 5: Rekap Harian
*(Buka halaman Rekap)*
- Tampilkan ringkasan penjualan per tanggal
- Grand total di bawah

---

## BAGIAN 9: Penutup (±1 menit)

Demikian penjelasan dari saya mengenai Sistem Manajemen Transaksi Penjualan Sederhana. Sistem ini menggunakan Laravel 13 dengan Blade Template murni, menerapkan pola MVC, dan memenuhi seluruh tantangan khusus yang ditentukan.

Terima kasih.

---

**Estimasi total durasi: ±22 menit**
