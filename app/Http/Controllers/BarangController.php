<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Tampilkan semua barang
    public function index()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang.index', compact('barangs'));
    }

    // Form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'harga_satuan'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil ditambahkan.');
    }

    // Detail satu barang
    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    // Form edit barang
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    // Update data barang
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'harga_satuan'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil diupdate.');
    }

    // Hapus barang
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil dihapus.');
    }
}
