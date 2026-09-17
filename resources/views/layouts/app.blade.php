<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .navbar { background: #333; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Sistem Penjualan</a>
            <div class="d-flex gap-3">
                <a href="{{ route('pelanggan.index') }}" class="text-white text-decoration-none">Pelanggan</a>
                <a href="{{ route('barang.index') }}" class="text-white text-decoration-none">Barang</a>
                <a href="{{ route('transaksi.index') }}" class="text-white text-decoration-none">Transaksi</a>
                <a href="{{ route('transaksi.rekap') }}" class="text-white text-decoration-none">Rekap</a>
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
