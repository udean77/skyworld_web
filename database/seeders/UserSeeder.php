<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'abcd1234', // ganti kalau mau lebih aman
            'role' => 'admin',
        ]);

        //12 Users
        for ($i = 1; $i <= 12; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}
