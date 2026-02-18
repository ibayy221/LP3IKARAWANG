<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureApplicant
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('pendaftar.login'));
        }

        // Allow all authenticated users (is_applicant check removed)
        return $next($request);
    }
}
