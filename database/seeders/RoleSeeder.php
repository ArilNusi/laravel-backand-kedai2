<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat peran admin
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web', // Pastikan nama kolomnya benar
        ]);

        // Buat peran user
        Role::create([
            'name' => 'user',
            'guard_name' => 'web', // Pastikan nama kolomnya benar
        ]);
        // Buat peran user
        Role::create([
            'name' => 'staff',
            'guard_name' => 'web', // Pastikan nama kolomnya benar
        ]);
    }
}
