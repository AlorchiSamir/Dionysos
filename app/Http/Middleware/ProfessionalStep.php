<?php

namespace App\Http\Middleware;
use Closure;

use App\Models\Professional;

class ProfessionalStep
{
    public function handle($request, Closure $next){
    	$route = $request->route()->getName();
    	$n = ($route == 'step') ? $request->n : null;
        $professional = Professional::getCurrent();
        if(!is_null($professional) && $professional->status < 10){
        	if($professional->status == Professional::STEP_1 && $n != 1){
        		return redirect('step/1');
        	}
        	if($professional->status == Professional::STEP_2 && $n != 2){
        		return redirect('step/2');
        	}
        	if($professional->status == Professional::STEP_3 && $n != 3){
        		return redirect('step/3');
        	}
            if($professional->status == Professional::STEP_4 && $n != 4){
                return redirect('step/4');
            }
        }
        return $next($request);
    }
}