<?php
namespace App\Http\Controllers;

use App\Models\Wahana;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\Status;
use Illuminate\Http\Request;
use PDF;
use Excel;

class TransaksiController extends Controller
{
    public function create()
    {
        $wahanas = Wahana::all();
        return view('v_transaksi.create', compact('wahanas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_customer' => 'required',
            'wahana_id' => 'required',
            'jumlah_tiket' => 'required|numeric|min:1',
            'status_id' => 'required'
        ]);

        $transaksi = Transaksi::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan!',
                'data' => $transaksi
            ]);
        }

        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $query = Transaksi::with(['customer', 'wahana', 'status']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('nama_status', $request->status);
            });
        }

        // Filter berdasarkan wahana
        if ($request->has('wahana') && $request->wahana != '') {
            $query->where('wahana_id', $request->wahana);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_awal') && $request->tanggal_awal != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaksi_id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('wahana', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $transaksis = $query->latest()->paginate(10);
        $wahanas = Wahana::all();
        $statuses = Status::all();

        if ($request->ajax()) {
            return view('v_transaksi.partials.transactions_table', compact('transaksis'));
        }

        return view('v_transaksi.index', compact('transaksis', 'wahanas', 'statuses'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with(['customer', 'wahana', 'status'])->findOrFail($id);
        $statuses = Status::all();
        return view('v_transaksi.edit', compact('transaksi', 'statuses'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id'
        ]);

        $transaksi->update([
            'status_id' => $request->status_id
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui'
            ]);
        }

        return redirect()->route('transaksis.index')
            ->with('success', 'Status transaksi berhasil diperbarui!');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['customer', 'wahana', 'status'])->findOrFail($id);
        return view('v_transaksi.show', compact('transaksi'));
    }

    public function laporan()
    {
        $wahanas = Wahana::all();
        $statuses = Status::all();
        return view('v_transaksi.laporan', compact('wahanas', 'statuses'));
    }

    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // Tambahkan waktu ke tanggal awal dan akhir
        $tanggal_awal = $request->tanggal_awal . ' 00:00:00';
        $tanggal_akhir = $request->tanggal_akhir . ' 23:59:59';

        $query = Transaksi::with(['wahana', 'customer', 'status'])
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir]);

        // Filter by status
        if ($request->filled('status')) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('nama_status', $request->status);
            });
        }

        // Filter by wahana
        if ($request->filled('wahana')) {
            $query->where('wahana_id', $request->wahana);
        }

        $transaksis = $query->get();
        $wahanas = Wahana::all(); // Get all wahanas for the filter display

        $total_pendapatan = $transaksis->reduce(function ($carry, $trx) {
            return $carry + (($trx->wahana->harga ?? 0) * $trx->jumlah_tiket);
        }, 0);

        return view('v_transaksi.cetak_laporan', compact('transaksis', 'total_pendapatan', 'wahanas'));
    }

    public function cetakPdf()
    {
        $transaksis = Transaksi::with(['customer', 'wahana', 'status'])->get();

        $pdf = PDF::loadView('v_transaksi.cetak_laporan', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // Tambahkan waktu ke tanggal awal dan akhir
        $tanggal_awal = $request->tanggal_awal . ' 00:00:00';
        $tanggal_akhir = $request->tanggal_akhir . ' 23:59:59';

        $transaksis = Transaksi::with(['wahana', 'customer', 'status'])
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();

        $data = [];
        $total_pendapatan = 0;

        foreach ($transaksis as $trx) {
            $total_harga = ($trx->wahana->harga ?? 0) * $trx->jumlah_tiket;
            $total_pendapatan += $total_harga;

            $data[] = [
                'ID' => $trx->id,
                'Customer' => $trx->customer->nama ?? '-',
                'Wahana' => $trx->wahana->nama ?? '-',
                'Harga Tiket' => $trx->wahana->harga ?? 0,
                'Jumlah Tiket' => $trx->jumlah_tiket,
                'Total Harga' => $total_harga,
                'Status' => $trx->status->nama_status ?? '-',
                'Tanggal' => $trx->created_at->format('d-m-Y H:i')
            ];
        }

        // Tambahkan baris total di akhir
        $data[] = [
            'ID' => '',
            'Customer' => '',
            'Wahana' => '',
            'Harga Tiket' => '',
            'Jumlah Tiket' => 'Total Pendapatan:',
            'Total Harga' => $total_pendapatan,
            'Status' => '',
            'Tanggal' => ''
        ];

        return Excel::download(new \App\Exports\TransaksiExport($data), 'laporan-transaksi.xlsx');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus!'
            ]);
        }

        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
