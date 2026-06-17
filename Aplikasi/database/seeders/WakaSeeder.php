<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WakaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Wakil Kesiswaan',
            'email' =>'waka@gmail.com',
            'role' => 'waka',
            'nip' => '05072003',
            'password' => Hash::make('waka123'),
        ]);
    }
}
