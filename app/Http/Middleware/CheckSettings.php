<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Professional;
use App\Models\Professional\Setting;

class CheckSettings
{
   
    public function handle($request, Closure $next){
        $ctrl = [Setting::AVATAR, 'description'];
        $professional = Professional::getCurrent();
        if(!is_null($professional)){
            $settings = $professional->getAllSettings();
            $settings['description'] = $professional->description;
            foreach ($ctrl as $setting) {
                if($settings[$setting] == null || (isset(Setting::$defaults[$setting]) && $settings[$setting] == Setting::$defaults[$setting])){
                    $_SESSION['remind'][] = $setting;
                }
            }
            var_dump($_SESSION);
        }
        
        return $next($request);
    }
}
