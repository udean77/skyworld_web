<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wahana;
use App\Models\Transaksi;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class CustomerTransaksiController extends Controller
{
    // Form pemesanan tiket
    public function form()
    {
        $wahanas = \App\Models\Wahana::all();
        $schedules = \App\Models\Schedule::all();
        // Group schedules by wahana_id
        $schedulesByWahana = [];
        foreach ($schedules as $sch) {
            $schedulesByWahana[$sch->wahana_id][] = [
                'id' => $sch->id,
                'start_time' => $sch->start_time,
                'end_time' => $sch->end_time,
            ];
        }
        return view('customer.pesan_tiket', compact('wahanas', 'schedulesByWahana'));
    }

    // Proses pemesanan tiket
    public function pesan(Request $request)
    {
        $request->validate([
            'wahana_id' => 'required|exists:wahanas,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        $customer = $user->customer ?? null;
        if (!$customer) {
            // Buat customer jika belum ada
            $customer = $user->customer()->create([
                'kode_customer' => 'CUST-' . strtoupper(uniqid()),
                'nama' => $user->name,
                'email' => $user->email,
                'no_telp' => $user->no_telp ?? '',
            ]);
        }
        $status = Status::where('nama_status', 'tidak terpakai')->first();
        // Simpan transaksi dengan schedule_id
        \App\Models\TicketPurchase::create([
            'customer_id' => auth()->user()->id,
            'wahana_id' => $request->wahana_id,
            'schedule_id' => $request->schedule_id,
            'jumlah_tiket' => $request->jumlah_tiket,
            // ...hitung total_harga...
        ]);
        return redirect()->route('customer.riwayat')->with('success', 'Tiket berhasil dipesan!');
    }

    // Riwayat transaksi customer
    public function riwayat()
    {
        $user = Auth::user();
        $customer = $user->customer;
        $transaksis = $customer ? $customer->transaksis()->with(['wahana', 'status'])->latest()->get() : collect();
        return view('customer.riwayat_transaksi', compact('transaksis'));
    }

    // Cetak invoice transaksi
    public function invoice($id)
    {
        $transaksi = \App\Models\Transaksi::with(['wahana', 'status', 'customer'])->findOrFail($id);
        // Optional: validasi hanya customer terkait yang bisa akses
        if (auth()->check() && $transaksi->customer->email !== auth()->user()->email) {
            abort(403);
        }
        return view('customer.invoice', compact('transaksi'));
    }
}
