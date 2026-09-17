@extends('layouts.app')

@section('content')
    <h2>Edit Pelanggan</h2>

    <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST" style="max-width:500px">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control"
                   value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" class="form-control"
                   value="{{ old('no_telepon', $pelanggan->no_telepon) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
