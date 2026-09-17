<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Tampilkan semua pelanggan
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();
        return view('pelanggan.index', compact('pelanggans'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('pelanggan.create');
    }

    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_telepon'     => 'nullable|string|max:20',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    // Detail satu pelanggan
    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    // Form edit pelanggan
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Update data pelanggan
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'no_telepon'     => 'nullable|string|max:20',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diupdate.');
    }

    // Hapus pelanggan
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
