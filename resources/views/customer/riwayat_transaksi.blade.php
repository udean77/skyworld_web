@extends('layouts.user')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat Transaksi
                    </h3>
                </div>
                <div class="card-body">
                    @if($transaksis->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada transaksi yang dilakukan</h4>
                            <p class="text-muted">Silakan pesan tiket wahana untuk melihat riwayat transaksi Anda</p>
                            <a href="{{ route('customer.pesan_tiket.form') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-ticket-alt mr-2"></i>Pesan Tiket
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Wahana</th>
                                        <th>Kode Transaksi</th>
                                        <th class="text-center">Jumlah Tiket</th>
                                        <th class="text-right">Total Harga</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksis as $index => $transaksi)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $transaksi->transaksi_id }}</td>
                                            <td>{{ $transaksi->wahana->nama ?? '-' }}</td>
                                            <td class="text-center">{{ $transaksi->jumlah_tiket }}</td>
                                            <td class="text-right">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>   
                                            <td class="text-center">
                                                @if(($transaksi->status->nama_status ?? '') === 'dibatalkan')
                                                    <span class="badge badge-danger">{{ $transaksi->status->nama_status }}</span>
                                                @elseif(($transaksi->status->nama_status ?? '') === 'belum terpakai' || ($transaksi->status->nama_status ?? '') === 'pending')
                                                    <span class="badge badge-warning">belum dibayar</span>
                                                @elseif(($transaksi->status->nama_status ?? '') === 'terpakai' || ($transaksi->status->nama_status ?? '') === 'paid')
                                                    <span class="badge badge-success">sudah dibayar</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $transaksi->status->nama_status ?? '-' }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y H:i') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('customer.transaksi.invoice', $transaksi->id) }}" class="btn btn-sm btn-info">Cetak Invoice</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .table th,
    .table td {
        vertical-align: middle;
    }
    .table thead th {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .badge {
        padding: 0.5em 0.7em;
        font-size: 85%;
        font-weight: 600;
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
</style>
@endpush
@endsection
