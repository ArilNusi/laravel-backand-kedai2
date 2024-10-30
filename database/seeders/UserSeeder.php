<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan untuk mengimpor model User
use App\Models\Staff; // Pastikan untuk mengimpor model Staff jika ada

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@role.test',
            'password' => bcrypt('admin123')
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'user',
            'email' => 'user@role.test',
            'password' => bcrypt('user123')
        ]);
        $user->assignRole('user');

       
    }
}
