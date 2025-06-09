<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wahana;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
class CustomerTransaksiController extends Controller
{
    // Form pemesanan tiket
    public function form(Request $request)
    {
        $wahanas = Wahana::all();

        return view('customer.pesan_tiket', compact('wahanas'));
    }

    // Proses pemesanan tiket
    public function pesan(Request $request)
    {
        $request->validate([
            'wahana_id' => 'required|exists:wahanas,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $wahana = Wahana::findOrFail($request->wahana_id);

        // Simpan transaksi dulu dengan status pending
        $transaksi = Transaksi::create([
            'customer_id' => $customer->id,
            'wahana_id' => $wahana->id,
            'status_id' => 3,
            'jumlah_tiket' => $request->jumlah_tiket,
        ]);

        // Setup Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'TIKET-' . $transaksi->id . '-' . time(),
                'gross_amount' => $wahana->harga * $request->jumlah_tiket, // total bayar
            ],
            'customer_details' => [
                'first_name' => $customer->nama,
                'email' => $customer->email,
                'phone' => $customer->no_telp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('customer.payment', compact('snapToken', 'transaksi'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }


    // Riwayat transaksi customer
    public function riwayat()
    {
        $customer = Auth::guard('customer')->user();
        $transaksis = $customer->transaksis()->with(['wahana', 'status'])->latest()->get();
        return view('customer.riwayat_transaksi', compact('transaksis'));
    }

    // Cetak invoice transaksi
    public function invoice($id)
    {
        $transaksi = Transaksi::with(['wahana', 'customer', 'status'])->findOrFail($id);
        return view('customer.invoice', compact('transaksi'));
    }

    public function bayar($id)
    {
        $transaksi = Transaksi::with(['wahana', 'customer'])->findOrFail($id);

        if ($transaksi->status->nama_status !== 'belum dibayar') {
            return redirect()->route('customer.riwayat')->with('info', 'Transaksi sudah dibayar.');
        }

        return view('customer.payment', compact('transaksi'));
    }
    public function pembayaran($id)
    {
        $transaksi = Transaksi::with(['wahana', 'customer'])->findOrFail($id);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaksi->id,
                'gross_amount' => $transaksi->wahana->harga * $transaksi->jumlah_tiket,
            ],
            'customer_details' => [
                'first_name' => $transaksi->customer->nama,
                'email' => $transaksi->customer->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('customer.payment', compact('transaksi', 'snapToken'));
    }
}
