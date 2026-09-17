@extends('layouts.app')

@section('content')
    <h2>Tambah Barang</h2>

    <form action="{{ route('barang.store') }}" method="POST" style="max-width:500px">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Satuan (Rp)</label>
            <input type="number" name="harga_satuan" class="form-control" value="{{ old('harga_satuan', 0) }}" min="0" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
