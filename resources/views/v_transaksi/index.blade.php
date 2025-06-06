@extends('adminlte::page')
@section('title', 'Daftar Transaksi')
@section('content')

<h1>Daftar Transaksi</h1>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div style="overflow:auto; max-height:70vh;">
<table class="table table-bordered" style="min-width:1100px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Wahana</th>
            <th>Harga</th>
            <th>Jumlah Tiket</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksis as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->customer->nama ?? '-' }}</td>
            <td>{{ $t->wahana->nama ?? '-' }}</td>
            <td>Rp {{ number_format($t->wahana->harga ?? 0, 0, ',', '.') }}</td>
            <td>{{ $t->jumlah_tiket }}</td>
            <td>Rp {{ number_format(($t->wahana->harga ?? 0) * $t->jumlah_tiket, 0, ',', '.') }}</td>
            <td>
                @if(($t->status->nama_status ?? '') === 'tidak terpakai')
                    <span style="background-color:#f8d7da;color:#721c24;padding:4px 10px;border-radius:5px;display:inline-block;">{{ $t->status->nama_status }}</span>
                @elseif(($t->status->nama_status ?? '') === 'tiket terpakai')
                    <span style="background-color:#d4edda;color:#155724;padding:4px 10px;border-radius:5px;display:inline-block;">{{ $t->status->nama_status }}</span>
                @else
                    {{ $t->status->nama_status ?? '-' }}
                @endif
            </td>
            <td>
                <a href="{{ route('transaksis.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit Status</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
