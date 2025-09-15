<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' =>'lboy9428@gmail.com',
            'role' => 'admin',
            'nip' => '1234567890', // isi dengan nip admin
            'password' => Hash::make('password123'), // ganti dengan password aman
        ]);
    }
}
