@extends('adminlte::page')
@section('title', 'Edit User')
@section('content')

<h1>Edit User</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <button class="btn btn-primary mt-2">Update</button>
</form>

@endsection
