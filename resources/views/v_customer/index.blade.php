@extends('adminlte::page')
@section('title', 'Customer Management')
@section('content')

<h1>Daftar Customer</h1>
<a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Tambah Customer</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="overflow:auto; max-height:70vh;">
<table class="table table-bordered" style="min-width:700px;">
    <thead>
        <tr>
            <th>Kode Customer</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $c)
        <tr>
            <td>{{ $c->kode_customer }}</td>
            <td>{{ $c->nama }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->no_telp }}</td>
            <td>
                <a href="{{ route('customers.edit', $c->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('customers.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus customer?')">
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
