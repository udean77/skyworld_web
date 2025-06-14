<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\Wahana;
use App\Models\Status;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 50 Customer
        Customer::factory()->count(50)->create();

        // Data dummy untuk transaksi
        $customers = Customer::all();
        $wahanas = Wahana::all();
        $statuses = Status::all();

        // Buat 100 transaksi dummy
        for ($i = 0; $i < 100; $i++) {
            // Generate tanggal random dalam 3 bulan terakhir
            $createdAt = Carbon::now()->subDays(rand(0, 90));
            
            Transaksi::create([
                'transaksi_id' => 'TRX-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'kode_customer' => $customers->random()->kode_customer,
                'wahana_id' => $wahanas->random()->id,
                'jumlah_tiket' => rand(1, 5),
                'status_id' => $statuses->random()->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }
    }
}
