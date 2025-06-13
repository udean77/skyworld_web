<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wahana;
use App\Models\Transaksi;
// use App\Models\Pemesanan; // jika sudah ada dan ingin menambah pemesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah data
        $totalUser = User::count();
        $totalWahana = Wahana::count();
        $totalTransaksi = Transaksi::count();

        // Data untuk grafik (7 hari terakhir)
        $transaksiHarian = Transaksi::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total_transaksi'),
            DB::raw('SUM(jumlah_tiket) as total_tiket')
        )
        ->whereBetween('created_at', [now()->subDays(6), now()])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        // Format data untuk grafik
        $labels = $transaksiHarian->pluck('tanggal')->map(function($date) {
            return date('d M', strtotime($date));
        });
        $dataTransaksi = $transaksiHarian->pluck('total_transaksi');
        $dataTiket = $transaksiHarian->pluck('total_tiket');

        // Mengirim data ke view
        return view('dashboard', compact(
            'totalUser', 
            'totalWahana', 
            'totalTransaksi',
            'labels',
            'dataTransaksi',
            'dataTiket'
        ));
    }
}
