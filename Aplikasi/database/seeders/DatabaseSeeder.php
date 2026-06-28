<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(WakaSeeder::class);
        $this->call(SiswaSeeder::class);
        
        User::factory()->create([
            'name' => 'Test User',
            'role' => 'siswa',
            'nisn' => '20250915',
            'password' => 'password123'
        ]);


    }
}
