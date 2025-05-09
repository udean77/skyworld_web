@extends('adminlte::page')
@section('title', 'Edit Wahana')
@section('content')

<h1>Edit Wahana</h1>

<form action="{{ route('wahana.update', $wahana->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ $wahana->nama }}" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4" required>{{ $wahana->deskripsi }}</textarea>
    </div>
    <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" value="{{ $wahana->harga }}" required>
    </div>
    <div class="form-group">
        <label>Gambar (Kosongkan jika tidak diubah)</label><br>
        @if($wahana->gambar)
            <img src="{{ asset('storage/' . $wahana->gambar) }}" width="100" class="mb-2"><br>
        @endif
        <input type="file" name="gambar" class="form-control">
    </div>
    <div class="form-group">
        <label>Stok Tiket</label>
        <input type="number" name="stok" class="form-control" value="{{ $wahana->stok }}" required>
    </div>

    <button class="btn btn-primary mt-2">Update</button>
</form>

@endsection
