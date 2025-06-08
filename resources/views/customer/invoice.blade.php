@extends('layouts.user')
@section('title', 'Invoice Transaksi')
@section('content')
<div class="container" style="max-width:600px; margin:40px auto;">
    <div class="card" style="border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.08); padding:32px;">
        <h2 class="text-center mb-4" style="color:#a23bb9; font-weight:bold;">INVOICE PEMESANAN TIKET</h2>
        <hr>
        <div class="mb-3">
            <strong>ID Transaksi:</strong> {{ $transaksi->id }}<br>
            <strong>Nama Customer:</strong> {{ $transaksi->customer->nama }}<br>
            <strong>Email:</strong> {{ $transaksi->customer->email }}<br>
            <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}<br>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Wahana</th>
                <td>{{ $transaksi->wahana->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Harga Tiket</th>
                <td>Rp {{ number_format($transaksi->wahana->harga ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Jumlah Tiket</th>
                <td>{{ $transaksi->jumlah_tiket }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td><b>Rp {{ number_format(($transaksi->wahana->harga ?? 0) * $transaksi->jumlah_tiket, 0, ',', '.') }}</b></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $transaksi->status->nama_status ?? '-' }}</td>
            </tr>
        </table>
        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary">Cetak Invoice</button>
            <a href="{{ url('/customer/login/' . ($customer->id ?? '')) . '/riwayat' }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
