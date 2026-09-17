@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Pelanggan</h2>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->nama_pelanggan }}</td>
                    <td>{{ $p->no_telepon ?? '-' }}</td>
                    <td>
                        <a href="{{ route('pelanggan.show', $p) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
