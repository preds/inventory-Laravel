<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->password_reset_required) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
