<?php

namespace App\Http\Middleware;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->isAdmin()) {
            return $next($request);
        }
        return redirect('/');
    }
}