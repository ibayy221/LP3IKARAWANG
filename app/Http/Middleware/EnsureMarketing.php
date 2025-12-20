<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMarketing
{
    public function handle(Request $request, Closure $next)
    {
        // Use the marketing guard
        if (!Auth::guard('marketing')->check()) {
            return redirect()->guest(route('marketing.login'));
        }

        $user = Auth::guard('marketing')->user();
        if (!$user || !$user->is_marketing) {
            abort(403, 'Forbidden: Marketing only');
        }

        return $next($request);
    }
}
