@extends('layouts.app')

@section('content')
    <h2>Detail Transaksi</h2>

    <table class="table" style="max-width:600px">
        <tr>
            <th>Kode Transaksi</th>
            <td>{{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <th>Pelanggan</th>
            <td>{{ $transaksi->pelanggan->nama_pelanggan }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h4>Item Transaksi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->barang->nama_barang }}</td>
                    <td>Rp {{ number_format($d->barang->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $d->jumlah }}</td>
                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
