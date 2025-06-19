<?php

namespace App\Http\Middleware;
use Closure;

class IsProfessional
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->isProfessional()) {
            return $next($request);
        }
        return redirect('/');
    }
}