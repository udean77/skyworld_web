<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('nama_role', 'admin')->value('id');
        $userRoleId = DB::table('roles')->where('nama_role', 'manager')->value('id');
        //Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'abcd1234', // ganti kalau mau lebih aman
            'role_id' => $adminRoleId,
        ]);
        //12 Users
        for ($i = 1; $i <= 12; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role_id' => $userRoleId,
            ]);
        }
    }
}
