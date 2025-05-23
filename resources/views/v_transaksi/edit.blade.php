@extends('adminlte::page')
@section('title', 'Edit Status Transaksi')
@section('content')

<h1>Edit Status Transaksi</h1>
<form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="status_id" class="form-label">Status</label>
        <select name="status_id" id="status_id" class="form-control" required>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" {{ $transaksi->status_id == $status->id ? 'selected' : '' }}>{{ $status->nama_status }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update Status</button>
    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
