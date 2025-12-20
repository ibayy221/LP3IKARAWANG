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

        $user = Auth::user();
        if (!$user->is_applicant) {
            abort(403, 'Forbidden: Applicants only');
        }

        return $next($request);
    }
}
