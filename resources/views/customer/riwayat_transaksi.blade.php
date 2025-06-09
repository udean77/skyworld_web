@extends('layouts.user')
@section('title', 'Riwayat Transaksi')
@section('content')
<div class="main-title">Riwayat Transaksi</div>
<div style="max-width:900px; margin:0 auto;">
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:24px;">{{ session('success') }}</div>
    @endif
    @if($transaksis->isEmpty())
        <div style="color:#b2e0ff; text-align:center; margin:40px 0;">Belum ada transaksi.</div>
    @else
    <div style="overflow-x:auto;">
        <table style="width:100%; background:rgba(20,30,60,0.97); color:#fff; border-radius:18px; overflow:hidden; border-collapse:separate; border-spacing:0; box-shadow:0 4px 24px #0002;">
            <thead style="background:#22304a;">
                <tr style="color:#ffe066;">
                    <th style="padding:14px 8px;">No</th>
                    <th>Wahana</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Waktu Bermain</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $trx)
                <tr style="vertical-align:middle;">
                    <td style="text-align:center; font-weight:600;">{{ $loop->iteration }}</td>
                    <td style="text-align:center;">{{ $trx->wahana->nama ?? '-' }}</td>
                    <td style="text-align:center;">{{ $trx->jumlah_tiket }}</td>
                    <td style="text-align:center; color:#ffe066; font-weight:600;">Rp {{ number_format(($trx->wahana->harga ?? 0) * $trx->jumlah_tiket, 0, ',', '.') }}</td>
                    <td style="text-align:center;">
                        {{ $trx->schedule->start_time ?? '-' }}{{ isset($trx->schedule->end_time) ? ' - ' . $trx->schedule->end_time : '' }}
                    </td>
                    <td style="text-align:center;">
    @if(($trx->status->nama_status ?? '') === 'tidak terpakai')
        <span style="background:#f5c242;color:#222;padding:4px 14px;border-radius:16px;display:inline-block;font-weight:600;">
            {{ $trx->status->nama_status }}
        </span>
    @elseif(($trx->status->nama_status ?? '') === 'tiket terpakai')
        <span style="background:#4caf50;color:#fff;padding:4px 14px;border-radius:16px;display:inline-block;font-weight:600;">
            {{ $trx->status->nama_status }}
        </span>
    @elseif(($trx->status->nama_status ?? '') === 'belum dibayar')
        <a href="{{ route('customer.transaksi.bayar', $trx->id) }}" style="background:#ff9800;color:#fff;padding:4px 14px;border-radius:16px;display:inline-block;font-weight:600;text-decoration:none;">
            {{ $trx->status->nama_status }}
        </a>
    @else
        <span style="background:#eee;color:#888;padding:4px 14px;border-radius:16px;display:inline-block;">
            {{ $trx->status->nama_status ?? '-' }}
        </span>
    @endif
</td>
                    <td style="text-align:center;">{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td style="text-align:center;">
                        <a href="{{ route('customer.transaksi.invoice', $trx->id) }}" class="btn btn-primary" style="padding:4px 14px; background:#007bff; color:#fff; border-radius:16px; text-decoration:none;">
                            Invoice
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
