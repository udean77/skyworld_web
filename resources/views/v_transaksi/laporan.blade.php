@extends('adminlte::page')
@section('title', 'Cetak Laporan Transaksi')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cetak Laporan Transaksi</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('transaksis.cetak') }}" target="_blank" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_awal">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->nama_status }}">
                                                {{ ucfirst($status->nama_status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wahana">Wahana</label>
                                    <select name="wahana" id="wahana" class="form-control">
                                        <option value="">Semua Wahana</option>
                                        @foreach($wahanas as $wahana)
                                            <option value="{{ $wahana->id }}">
                                                {{ $wahana->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf"></i> Cetak PDF
                                    </button>
                                    <a href="{{ route('transaksis.cetak-excel') }}" class="btn btn-success" target="_blank">
                                        <i class="fas fa-file-excel"></i> Cetak Excel
                                    </a>
                                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 