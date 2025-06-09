<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['nama_status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'failed', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'expired', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'belum terpakai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'terpakai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}