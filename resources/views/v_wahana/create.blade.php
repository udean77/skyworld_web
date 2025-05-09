@extends('adminlte::page')
@section('title', 'Tambah Wahana')
@section('content')

<h1>Tambah Wahana</h1>

<form action="{{ route('wahana.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </div>
    <div class="form-group">
        <label>Stok Tiket</label>
        <input type="number" name="stok" class="form-control" required>
    </div>

    
    <button class="btn btn-success mt-2">Simpan</button>
</form>

@endsection
