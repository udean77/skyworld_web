<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #4a4a4a;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #888;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        tfoot td {
            font-weight: bold;
        }
        .filter-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Tiket</h2>

    <div class="filter-info">
        Dicetak oleh: {{ $user->name ?? 'Admin' }}
        <br>
        Tanggal Cetak: {{ now()->format('d-m-Y H:i:s') }}
    </div>

    @if(request('status') || request('wahana'))
    <div class="filter-info">
        Filter: 
        @if(request('status'))
            Status: {{ ucfirst(request('status')) }}
        @endif
        @if(request('wahana'))
            @if(request('status')), @endif
            Wahana: {{ $wahanas->firstWhere('id', request('wahana'))->nama ?? 'Semua Wahana' }}
        @endif
    </div>
    @endif

    @php
        $statusSummary = [
            'terpakai' => 0,
            'belum terpakai' => 0,
            'dibatalkan' => 0,
        ];

        $pendapatanTerpakai = 0;
        $totalPendapatan = 0;
    @endphp

    @foreach ($transaksis as $trx)
        @php
            $status = strtolower($trx->status->nama_status ?? 'unknown');
            $harga = $trx->wahana->harga ?? 0;
            $subtotal = $harga * $trx->jumlah_tiket;

            if (isset($statusSummary[$status])) {
                $statusSummary[$status]++;
            }

            if ($status === 'terpakai') {
                $pendapatanTerpakai += $subtotal;
            }
            $totalPendapatan += $subtotal;
        @endphp
    @endforeach

    <h3>Ringkasan Status Transaksi</h3>
    <table style="width: 60%; margin: 0 auto 30px auto;">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statusSummary as $status => $jumlah)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td>{{ $jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align:right;">Total Pendapatan (Tiket Terpakai)</td>
                <td><strong>Rp {{ number_format($pendapatanTerpakai, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3>Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Wahana</th>
                <th>Harga Tiket</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $trx)
                @php 
                    $totalHarga = ($trx->wahana->harga ?? 0) * $trx->jumlah_tiket;
                @endphp
                <tr>
                    <td>{{ $trx->id }}</td>
                    <td>{{ $trx->customer->nama ?? '-' }}</td>
                    <td>{{ $trx->wahana->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($trx->wahana->harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $trx->jumlah_tiket }}</td>
                    <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    <td>{{ $trx->status->nama_status ?? '-' }}</td>
                    <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;">Total Semua Transaksi:</td>
                <td colspan="3">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
