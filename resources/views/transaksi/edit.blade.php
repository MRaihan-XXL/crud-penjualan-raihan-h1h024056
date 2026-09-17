@extends('layouts.app')

@section('content')
    <h2>Edit Transaksi</h2>

    <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Pelanggan</label>
                <select name="pelanggan_id" class="form-select" required>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id }}" {{ $transaksi->pelanggan_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_pelanggan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $transaksi->tanggal }}" required>
            </div>
        </div>

        <h4>Item Transaksi</h4>
        <div id="items-container">
            @foreach($transaksi->detailTransaksi as $d)
                <div class="row mb-2 item-row">
                    <div class="col-md-5">
                        <select name="item_barang_id[]" class="form-select" required>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}" data-harga="{{ $b->harga_satuan }}" data-stok="{{ $b->stok }}"
                                    {{ $d->barang_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="item_jumlah[]" class="form-control jumlah-input"
                               value="{{ $d->jumlah }}" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control subtotal-display" readonly
                               value="Rp {{ number_format($d->subtotal, 0, ',', '.') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger btn-remove-item">Hapus</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-sm btn-success mb-3" id="btn-add-item">+ Tambah Item</button>

        <div class="mb-3">
            <strong>Total: <span id="total-display">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span></strong>
        </div>

        <button class="btn btn-primary">Update Transaksi</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    <script>
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('jumlah-input')) {
                hitungSubtotal(e.target);
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove-item')) {
                e.target.closest('.item-row').remove();
                hitungTotal();
            }
        });

        document.getElementById('btn-add-item').addEventListener('click', function() {
            var container = document.getElementById('items-container');
            var template = container.querySelector('.item-row').cloneNode(true);
            template.querySelector('select').value = '';
            template.querySelector('.jumlah-input').value = '';
            template.querySelector('.subtotal-display').value = 'Rp 0';
            container.appendChild(template);
        });

        function hitungSubtotal(input) {
            var row = input.closest('.item-row');
            var select = row.querySelector('select');
            var option = select.options[select.selectedIndex];
            var harga = parseInt(option.getAttribute('data-harga')) || 0;
            var jumlah = parseInt(input.value) || 0;
            var subtotal = harga * jumlah;
            row.querySelector('.subtotal-display').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            hitungTotal();
        }

        function hitungTotal() {
            var total = 0;
            document.querySelectorAll('.subtotal-display').forEach(function(el) {
                var val = el.value.replace(/[^0-9]/g, '');
                total += parseInt(val) || 0;
            });
            document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
@endsection
