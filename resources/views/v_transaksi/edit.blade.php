@extends('adminlte::page')
@section('title', 'Edit Status Transaksi')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Status Transaksi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select name="status_id" id="status_id" class="form-control" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $transaksi->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                            <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
