@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalWahana }}</h3>
                <p>Total Wahana</p>
            </div>
            <div class="icon">
                <i class="fas fa-rocket"></i>
            </div>
            <a href="{{ route('wahana.index') }}" class="small-box-footer">
                Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalUser }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    {{-- Tambahkan bagian lainnya jika perlu --}}
</div>
@stop
