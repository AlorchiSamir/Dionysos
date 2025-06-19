<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Professional;
use App\Models\Metier;

class isHallOwner
{
   
    public function handle($request, Closure $next)
    {       
        $professional = Professional::getCurrent();
        if(!is_null($professional) && $professional->metiers[0]->name == Metier::HALL_OWNER){
            return $next($request);
        }        
        return redirect('/');
    }
}
