<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wahana;
// use App\Models\Pemesanan; // jika sudah ada dan ingin menambah pemesanan
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah data
        $totalUser = User::count();
        $totalWahana = Wahana::count();
        // $totalPemesanan = Pemesanan::count(); // jika ada tabel pemesanan

        // Mengirim data ke view
        return view('dashboard', compact('totalUser', 'totalWahana'));
    }
}
