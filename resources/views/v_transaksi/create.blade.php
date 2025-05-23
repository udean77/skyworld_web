@extends('adminlte::page')
@section('title', 'Pesan Tiket')
@section('content')

<h1>Pemesanan Tiket</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('transaksis.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="customer_nama" class="form-label">Nama Customer</label>
        <input type="text" name="customer_nama" id="customer_nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="wahana_id" class="form-label">Pilih Wahana</label>
        <select name="wahana_id" id="wahana_id" class="form-control" required>
            <option value="">-- Pilih Wahana --</option>
            @foreach($wahanas as $wahana)
                <option value="{{ $wahana->id }}">{{ $wahana->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
        <input type="number" name="jumlah_tiket" id="jumlah_tiket" class="form-control" min="1" required>
    </div>
    <button type="submit" class="btn btn-success">Pesan Tiket</button>
</form>

@endsection
