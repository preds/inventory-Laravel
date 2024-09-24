<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->group->level == 'Administrator') {
            return $next($request);
        }
        return redirect('/'); // Redirige vers la page d'accueil si l'utilisateur n'est pas un administrateur
    }
}
