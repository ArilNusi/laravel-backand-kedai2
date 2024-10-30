<?php

namespace App\Policies;

use App\Models\User;


{
    class PostPolicy
    {
        public function create(User $user)
        {
            // Semua role bisa menambah
            return in_array($user->role, ['staff', 'user']);
        }

        public function update(User $user)
        {
            // Hanya role staff yang bisa edit
            return $user->role === 'staff';
        }
    }



}
