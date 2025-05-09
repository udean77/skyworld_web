<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wahana;
class WahanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wahana::create([
            'nama' => 'Kolam Renang Anak',
            'deskripsi' => 'Kolam dangkal untuk anak-anak',
            'harga' => 25000,
            'stok' => 100,
        ]);
    
        Wahana::create([
            'nama' => 'Seluncuran Air',
            'deskripsi' => 'Wahana seluncuran air ekstrim',
            'harga' => 40000,
            'stok' => 100,
        ]);
    }
}
