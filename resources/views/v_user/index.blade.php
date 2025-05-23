@extends('adminlte::page')
@section('title', 'User Management')
@section('content')

<h1>Daftar User</h1>
<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah User</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="overflow:auto; max-height:70vh;">
<table class="table table-bordered" style="min-width:700px;">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role->nama_role ?? '-' }}</td>
            <td>
                <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
