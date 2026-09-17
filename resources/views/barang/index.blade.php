@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Barang</h2>
        <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $b->stok }}</td>
                    <td>
                        <a href="{{ route('barang.show', $b) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('barang.edit', $b) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $b) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
