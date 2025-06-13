<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Wahana;
use App\Models\Status;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 Wahana
        Wahana::factory()->count(10)->create();

        // Buat 3 Status
        foreach ($statuses as $status) {
            Status::firstOrCreate(['nama_status' => $status]);
        }

        // Buat 50 Customer
        Customer::factory()->count(50)->create();

        // Ambil data untuk digunakan
        $customers = Customer::all();
        $wahanas = Wahana::all();
        $statusIds = Status::pluck('id', 'nama_status');

        // Generate 20 transaksi per hari dari 1-10 Juni 2025
        for ($day = 1; $day <= 10; $day++) {
            for ($i = 0; $i < 20; $i++) {
                $customer = $customers->random();
                $wahana = $wahanas->random();
                $statusId = $statusIds->random();
                $jumlahTiket = rand(1, 5);

                $tanggal = Carbon::create(2025, 6, $day, rand(8, 20), rand(0, 59));

                Transaksi::create([
                    'customer_id' => $customer->id,
                    'wahana_id' => $wahana->id,
                    'status_id' => $statusId,
                    'jumlah_tiket' => $jumlahTiket,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);
            }
        }
    }
}
