@extends('adminlte::page')
@section('title', 'Tambah User')
@section('content')

<h1>Tambah User</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button class="btn btn-success mt-2">Simpan</button>
</form>

@endsection
