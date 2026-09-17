@extends('layouts.app')

@section('content')
    <h2>Sistem Manajemen Transaksi Penjualan</h2>
    <p class="text-muted">Paket Soal 6 — Muhammad Raihan (H1H024056)</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <a href="{{ route('pelanggan.index') }}" class="card text-decoration-none">
                <div class="card-body text-center">
                    <h5>Pelanggan</h5>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('barang.index') }}" class="card text-decoration-none">
                <div class="card-body text-center">
                    <h5>Barang</h5>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('transaksi.index') }}" class="card text-decoration-none">
                <div class="card-body text-center">
                    <h5>Transaksi</h5>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('transaksi.rekap') }}" class="card text-decoration-none">
                <div class="card-body text-center">
                    <h5>Rekap Harian</h5>
                </div>
            </a>
        </div>
    </div>
@endsection
