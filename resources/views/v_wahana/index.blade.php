@extends('adminlte::page')

@section('title', 'Daftar Wahana')

@section('content_header')
    <h1>Daftar Wahana</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tabel Daftar Wahana -->
        <div class="card">
            <div class="card-header">
                <a href="{{ route('wahana.create') }}" class="btn btn-primary">Tambah Wahana</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th> <!-- Kolom Stok -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $wahana)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $wahana->nama }}</td>
                                <td>{{ $wahana->deskripsi }}</td>
                                <td>{{ number_format($wahana->harga, 0, ',', '.') }}</td>
                                <td>{{ $wahana->stok }}</td> <!-- Menampilkan stok -->
                                <td>
                                    <a href="{{ route('wahana.edit', $wahana->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('wahana.destroy', $wahana->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus wahana ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
