<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Membuat atau mendapatkan role 'admin'
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $role = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);


        // Membuat user baru jika belum ada dengan email tertentu
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Gantilah dengan password yang sesuai
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Gantilah dengan password yang sesuai
            ]
        );

        // Menugaskan role ke user
        $user->assignRole($role);

        // Memeriksa apakah role 'admin' berhasil ditugaskan
        if ($user->hasRole('admin')) {
            echo "User has been successfully assigned the 'admin' role.\n";
        } else {
            echo "Failed to assign the 'admin' role to the user.\n";
  }
}
}
