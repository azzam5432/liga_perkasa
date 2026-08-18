<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya Super Admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
