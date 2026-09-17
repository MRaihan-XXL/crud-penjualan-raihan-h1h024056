@extends('layouts.app')

@section('content')
    <h2>Rekap Penjualan Harian</h2>
    <p class="text-muted">Total penjualan dikelompokkan per tanggal</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->tanggal }}</td>
                    <td>{{ $r->jumlah_transaksi }}</td>
                    <td>Rp {{ number_format($r->total_penjualan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Belum ada data transaksi.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Grand Total</th>
                <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
