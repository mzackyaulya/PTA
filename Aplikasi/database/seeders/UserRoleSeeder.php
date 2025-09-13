<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    
    public function run(): void
    {
        User::where('id', 1)->update(['role' => 'admin']);
        User::where('id', 2)->update(['role' => 'siswa']);
        User::where('id', 3)->update(['role' => 'guru']);
    }
}
