@extends('layouts.app')

@section('content')
    <h2>Detail Pelanggan</h2>

    <table class="table" style="max-width:500px">
        <tr>
            <th>Nama</th>
            <td>{{ $pelanggan->nama_pelanggan }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $pelanggan->no_telepon ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
