@extends('adminlte::page')
@section('title', 'Detail Transaksi')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Transaksi #{{ $transaksi->id }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID Transaksi</th>
                            <td>{{ $transaksi->id }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $transaksi->customer->nama ?? '-' }}</td>
                        </tr>
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
                            <th>Total Harga</th>
                            <td>Rp {{ number_format(($transaksi->wahana->harga ?? 0) * $transaksi->jumlah_tiket, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if(($transaksi->status->nama_status ?? '') === 'belum terpakai')
                                    <span style="background-color:#f8d7da;color:#721c24;padding:4px 10px;border-radius:5px;display:inline-block;">{{ $transaksi->status->nama_status }}</span>
                                @elseif(($transaksi->status->nama_status ?? '') === 'terpakai')
                                    <span style="background-color:#d4edda;color:#155724;padding:4px 10px;border-radius:5px;display:inline-block;">{{ $transaksi->status->nama_status }}</span>
                                @elseif(($transaksi->status->nama_status ?? '') === 'dibatalkan')
                                    <span style="background-color:#fff3cd;color:#856404;padding:4px 10px;border-radius:5px;display:inline-block;">{{ $transaksi->status->nama_status }}</span>
                                @else
                                    {{ $transaksi->status->nama_status ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $transaksi->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('transaksis.edit', $transaksi->id) }}" class="btn btn-warning">Edit Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 