<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'hoangpham23052003@gmail.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);
    }
}
