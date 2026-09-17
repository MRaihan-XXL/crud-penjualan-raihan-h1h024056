@extends('layouts.app')

@section('content')
    <h2>Detail Barang</h2>

    <table class="table" style="max-width:500px">
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Stok</th>
            <td>{{ $barang->stok }}</td>
        </tr>
    </table>

    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
