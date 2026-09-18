<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect('/');
        }

        if (! in_array($request->user()->role, $roles)) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if (! $request->user()->is_active) {
            auth()->logout();

            return redirect('/')->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        return $next($request);
    }
}
