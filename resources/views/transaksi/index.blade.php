@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Transaksi</h2>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->kode_transaksi }}</td>
                    <td>{{ $t->pelanggan->nama_pelanggan }}</td>
                    <td>{{ $t->tanggal }}</td>
                    <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $t) }}" class="btn btn-sm btn-info">Detail</a>
                        <form action="{{ route('transaksi.destroy', $t) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus transaksi ini? Stok barang akan dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
