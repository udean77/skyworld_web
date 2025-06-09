@extends('layouts.user')
@section('title', 'Invoice Transaksi')
@section('content')
<div class="container" style="max-width:600px; margin:40px auto;">
    <div class="card shadow rounded-4 p-4" style="border-radius: 20px;">
        <h2 class="text-center mb-4" style="color:#a23bb9; font-weight:bold;">INVOICE PEMESANAN TIKET</h2>
        <hr>
        <div class="mb-4">
            <p><strong>ID Transaksi:</strong> {{ $transaksi->id }}</p>
            <p><strong>Nama Customer:</strong> {{ $transaksi->customer->nama }}</p>
            <p><strong>Email:</strong> {{ $transaksi->customer->email }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">Wahana</th>
                    <td>{{ $transaksi->wahana->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th scope="row">Harga Tiket</th>
                    <td>Rp {{ number_format($transaksi->wahana->harga ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th scope="row">Jumlah Tiket</th>
                    <td>{{ $transaksi->jumlah_tiket }}</td>
                </tr>
                <tr>
                    <th scope="row">Total</th>
                    <td><strong>Rp {{ number_format(($transaksi->wahana->harga ?? 0) * $transaksi->jumlah_tiket, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th scope="row">Status</th>
                    <td>{{ $transaksi->status->nama_status ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary me-2">Cetak Invoice</button>
            <a href="{{ route('customer.riwayat') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
