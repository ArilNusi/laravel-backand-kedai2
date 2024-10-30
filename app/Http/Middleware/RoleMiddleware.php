<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = Auth::user()->role; // Pastikan ada kolom `role` di tabel `users`

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect('/home')->with('error', "Anda tidak memiliki akses");
    }
}
