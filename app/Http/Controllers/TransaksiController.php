<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.index', compact('transaksis'));
    }

    // Form tambah transaksi baru
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $barangs    = Barang::orderBy('nama_barang')->get();

        // Generate kode transaksi otomatis: TRX + timestamp
        $kodeTransaksi = 'TRX' . date('YmdHis');

        return view('transaksi.create', compact('pelanggans', 'barangs', 'kodeTransaksi'));
    }

    // Simpan transaksi baru beserta detail-itemnya
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'tanggal'           => 'required|date',
            'item_barang_id'    => 'required|array|min:1',
            'item_barang_id.*'  => 'required|exists:barang,id',
            'item_jumlah.*'     => 'required|integer|min:1',
        ]);

        // Hitung subtotal per item, cek stok, hitung total
        $totalTransaksi = 0;
        $detailItems    = [];

        for ($i = 0; $i < count($validated['item_barang_id']); $i++) {
            $barang = Barang::find($validated['item_barang_id'][$i]);
            $jumlah = $validated['item_jumlah'][$i];

            // Tantangan khusus 2: validasi stok tidak boleh minus
            if ($jumlah > $barang->stok) {
                return back()->withInput()
                    ->with('error', "Stok barang \"{$barang->nama_barang}\" tidak mencukupi. Stok tersisa: {$barang->stok}.");
            }

            // Tantangan khusus 1: hitung otomatis subtotal
            $subtotal = $barang->harga_satuan * $jumlah;

            $detailItems[] = [
                'barang_id' => $barang->id,
                'jumlah'    => $jumlah,
                'subtotal'  => $subtotal,
            ];

            $totalTransaksi += $subtotal;
        }

        // Simpan dalam transaksi database supaya aman
        DB::transaction(function () use ($validated, $detailItems, $totalTransaksi, $request) {
            // Buat transaksi header
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX' . date('YmdHis'),
                'pelanggan_id'   => $validated['pelanggan_id'],
                'tanggal'        => $validated['tanggal'],
                'total'          => $totalTransaksi,
            ]);

            // Simpan detail item
            foreach ($detailItems as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $item['barang_id'],
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // Kurangi stok barang
                $barang = Barang::find($item['barang_id']);
                $barang->decrement('stok', $item['jumlah']);
            }
        });

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil disimpan.');
    }

    // Detail transaksi
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'detailTransaksi.barang']);

        return view('transaksi.show', compact('transaksi'));
    }

    // Form edit transaksi
    public function edit(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.barang');
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        $barangs    = Barang::orderBy('nama_barang')->get();

        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'barangs'));
    }

    // Update transaksi
    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'tanggal'           => 'required|date',
            'item_barang_id'    => 'required|array|min:1',
            'item_barang_id.*'  => 'required|exists:barang,id',
            'item_jumlah.*'     => 'required|integer|min:1',
        ]);

        // Kembalikan stok lama
        foreach ($transaksi->detailTransaksi as $detail) {
            $barangLama = Barang::find($detail->barang_id);
            $barangLama->increment('stok', $detail->jumlah);
        }

        // Hapus detail lama
        $transaksi->detailTransaksi()->delete();

        // Hitung ulang
        $totalTransaksi = 0;
        $detailItems    = [];

        for ($i = 0; $i < count($validated['item_barang_id']); $i++) {
            $barang = Barang::find($validated['item_barang_id'][$i]);
            $jumlah = $validated['item_jumlah'][$i];

            if ($jumlah > $barang->stok) {
                return back()->withInput()
                    ->with('error', "Stok barang \"{$barang->nama_barang}\" tidak mencukupi. Stok tersisa: {$barang->stok}.");
            }

            $subtotal = $barang->harga_satuan * $jumlah;

            $detailItems[] = [
                'barang_id' => $barang->id,
                'jumlah'    => $jumlah,
                'subtotal'  => $subtotal,
            ];

            $totalTransaksi += $subtotal;
        }

        DB::transaction(function () use ($transaksi, $validated, $detailItems, $totalTransaksi) {
            $transaksi->update([
                'pelanggan_id' => $validated['pelanggan_id'],
                'tanggal'      => $validated['tanggal'],
                'total'        => $totalTransaksi,
            ]);

            foreach ($detailItems as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $item['barang_id'],
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $item['subtotal'],
                ]);

                $barang = Barang::find($item['barang_id']);
                $barang->decrement('stok', $item['jumlah']);
            }
        });

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil diupdate.');
    }

    // Hapus transaksi
    public function destroy(Transaksi $transaksi)
    {
        // Kembalikan stok sebelum hapus
        foreach ($transaksi->detailTransaksi as $detail) {
            $barang = Barang::find($detail->barang_id);
            if ($barang) {
                $barang->increment('stok', $detail->jumlah);
            }
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }

    // Tantangan khusus 3: halaman rekap/laporan total penjualan per hari
    public function rekap()
    {
        $rekap = Transaksi::select(
                'tanggal',
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $grandTotal = $rekap->sum('total_penjualan');

        return view('transaksi.rekap', compact('rekap', 'grandTotal'));
    }
}
