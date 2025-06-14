@extends('adminlte::page')
@section('title', 'Daftar Transaksi')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Transaksi</h3>
                    <div class="card-tools">
                        <a href="{{ route('transaksis.laporan') }}" class="btn btn-primary">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form id="filterForm" method="GET" action="{{ route('transaksis.index') }}" class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Semua Status</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->nama_status }}" {{ request('status') == $status->nama_status ? 'selected' : '' }}>
                                                        {{ ucfirst($status->nama_status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="wahana">Wahana</label>
                                            <select name="wahana" id="wahana" class="form-control">
                                                <option value="">Semua Wahana</option>
                                                @foreach($wahanas as $wahana)
                                                    <option value="{{ $wahana->id }}" {{ request('wahana') == $wahana->id ? 'selected' : '' }}>
                                                        {{ $wahana->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_awal">Tanggal Awal</label>
                                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_akhir">Tanggal Akhir</label>
                                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="search">Pencarian</label>
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="ID/Customer/Wahana" value="{{ request('search') }}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search"></i> Filter
                                                    </button>
                                                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary" id="resetBtn">
                                                        <i class="fas fa-sync"></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div id="transactionsTable">
                        @include('v_transaksi.partials.transactions_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .pagination {
        margin: 0;
    }
    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
    .page-link {
        color: #007bff;
    }
    .page-link:hover {
        color: #0056b3;
    }
    /* Compact table styles */
    .table {
        font-size: 0.85rem;
    }
    .table th, .table td {
        padding: 0.5rem;
        vertical-align: middle;
    }
    .table .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.3em 0.6em;
    }
    .table-responsive {
        max-height: 400px;
    }
    .form-group {
        margin-bottom: 0.5rem;
    }
    .form-control {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }
    .input-group-append .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }
    .card-body {
        padding: 0.75rem;
    }
    .card-header {
        padding: 0.75rem 1rem;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    // Handle form submission with AJAX
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        loadTransactions($(this).serialize());
    });

    // Handle reset button
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        $('#filterForm')[0].reset();
        loadTransactions();
    });

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadTransactions($('#filterForm').serialize() + '&page=' + page);
    });

    // Function to load transactions
    function loadTransactions(params = '') {
        $.ajax({
            url: '{{ route("transaksis.index") }}',
            data: params,
            success: function(response) {
                $('#transactionsTable').html(response);
                // Update URL without refresh
                let newUrl = '{{ route("transaksis.index") }}?' + params;
                window.history.pushState({path: newUrl}, '', newUrl);
            }
        });
    }
});
</script>
@endpush
@endsection
