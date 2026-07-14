<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah sudah login dan apakah rolenya ada di dalam daftar yang diizinkan
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar ke halaman default atau error 403
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}
