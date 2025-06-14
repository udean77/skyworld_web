<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-striped table-hover" style="min-width:1100px;">
        <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Tanggal Pesan</th>
                <th>Customer</th>
                <th>Wahana</th>
                <th>Harga</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $t)
            <tr>
                <td>{{ $transaksis->firstItem() + $index }}</td>
                <td>{{ $t->transaksi_id }}</td>
                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $t->customer->nama ?? '-' }}</td>
                <td>{{ $t->wahana->nama ?? '-' }}</td>
                <td>Rp {{ number_format($t->wahana->harga ?? 0, 0, ',', '.') }}</td>
                <td>{{ $t->jumlah_tiket }}</td>
                <td>Rp {{ number_format(($t->wahana->harga ?? 0) * $t->jumlah_tiket, 0, ',', '.') }}</td>
                <td>
                    @if(($t->status->nama_status ?? '') === 'dibatalkan')
                        <span class="badge badge-danger">{{ $t->status->nama_status }}</span>
                    @elseif(($t->status->nama_status ?? '') === 'belum terpakai')
                        <span class="badge badge-warning">{{ $t->status->nama_status }}</span>
                    @elseif(($t->status->nama_status ?? '') === 'terpakai')
                        <span class="badge badge-success">{{ $t->status->nama_status }}</span>
                    @else
                        <span class="badge badge-secondary">{{ $t->status->nama_status ?? '-' }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('transaksis.edit', $t->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('transaksis.show', $t->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('transaksis.destroy', $t->id) }}" class="btn btn-sm btn-danger delete-btn">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Menampilkan {{ $transaksis->firstItem() ?? 0 }} - {{ $transaksis->lastItem() ?? 0 }} dari {{ $transaksis->total() }} transaksi
    </div>
    <div>
        {{ $transaksis->links('pagination::bootstrap-4') }}
    </div>
</div> 