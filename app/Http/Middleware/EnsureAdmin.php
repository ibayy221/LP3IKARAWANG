<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // redirect to admin login
            return redirect()->guest(route('admin.login'));
        }

        $user = Auth::user();
        if (!$user->is_admin) {
            abort(403, 'Forbidden: Admins only');
        }

        return $next($request);
    }
}
