<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PanitiaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !(Auth::user()->isSuperAdmin() || Auth::user()->isPanitia())) {
            abort(403, 'Akses ditolak! Hanya Panitia yang dapat mengakses halaman ini.');
        }
        
        return $next($request);
    }
}
