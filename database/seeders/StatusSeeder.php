<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['nama_status' => 'belum terpakai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'terpakai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'dibatalkan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}