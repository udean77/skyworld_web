<?php
namespace App\Http\Controllers;

use App\Models\Wahana;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\Status;
use Illuminate\Http\Request;
use PDF;

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
            'customer_nama' => 'required|string|max:255',
            'wahana_id' => 'required|exists:wahanas,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        // Cari atau buat customer baru
        $customer = \App\Models\Customer::firstOrCreate(
            ['nama' => $request->customer_nama],
            [
                'kode_customer' => 'CUST-' . strtoupper(uniqid()),
                'email' => '',
                'no_telp' => ''
            ]
        );

        // Status default: tidak terpakai
        $status = \App\Models\Status::where('nama_status', 'tidak terpakai')->first();

        \App\Models\Transaksi::create([
            'customer_id' => $customer->id,
            'wahana_id' => $request->wahana_id,
            'status_id' => $status ? $status->id : 1,
            'jumlah_tiket' => $request->jumlah_tiket,
        ]);

        return redirect()->route('transaksis.create')->with('success', 'Pesanan tiket berhasil dibuat!');
    }

    public function index()
    {
        $transaksis = Transaksi::with(['customer', 'wahana', 'status'])->get();
        return view('v_transaksi.index', compact('transaksis'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with(['customer', 'wahana', 'status'])->findOrFail($id);
        $statuses = Status::all();
        return view('v_transaksi.edit', compact('transaksi', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_id = $request->status_id;
        $transaksi->save();
        return redirect()->route('transaksis.index')->with('success', 'Status transaksi berhasil diupdate!');
    }
    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $transaksis = Transaksi::with(['wahana', 'customer'])
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();

        $total_pendapatan = $transaksis->reduce(function ($carry, $trx) {
            return $carry + (($trx->wahana->harga ?? 0) * $trx->jumlah_tiket);
        }, 0);

        return view('v_transaksi.cetak_laporan', compact('transaksis', 'total_pendapatan'));
    }
    public function cetakPdf()
    {
        $transaksis = Transaksi::with(['customer', 'wahana', 'status'])->get();

        $pdf = PDF::loadView('v_transaksi.cetak_laporan', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
