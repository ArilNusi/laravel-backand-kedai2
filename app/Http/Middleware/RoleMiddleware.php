<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        // Periksa apakah role pengguna termasuk dalam array roles
        if (!in_array($user->role, $roles)) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);

    }

}
