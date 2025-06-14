<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wahana;
use App\Models\Transaksi;
use App\Models\Status;
// use App\Models\Pemesanan; // jika sudah ada dan ingin menambah pemesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah data
        $totalUser = User::count();
        $totalWahana = Wahana::count();
        $totalTransaksi = Transaksi::count();

        // Data untuk grafik (7 hari terakhir)
        $rawTransaksiHarian = Transaksi::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total_transaksi'),
            DB::raw('SUM(jumlah_tiket) as total_tiket')
        )
        ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        // Buat array tanggal untuk 7 hari terakhir
        $allDates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $allDates->push(now()->subDays($i)->format('Y-m-d'));
        }

        // Gabungkan data transaksi dengan semua tanggal
        $dataMap = $rawTransaksiHarian->keyBy('tanggal');

        $labels = $allDates->map(function($date) use ($dataMap) {
            return date('d M', strtotime($date));
        });

        $dataTransaksi = $allDates->map(function($date) use ($dataMap) {
            return $dataMap->has($date) ? $dataMap[$date]['total_transaksi'] : 0;
        });

        $dataTiket = $allDates->map(function($date) use ($dataMap) {
            return $dataMap->has($date) ? $dataMap[$date]['total_tiket'] : 0;
        });

        // Debugging logs
        \Log::info('Chart Labels: ' . json_encode($labels));
        \Log::info('Chart Data Transaksi: ' . json_encode($dataTransaksi));

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
