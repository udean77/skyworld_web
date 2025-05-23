<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['nama_status' => 'tiket terpakai', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'tidak terpakai', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
