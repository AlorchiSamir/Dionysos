<?php

namespace App\Models\Professional;

use Illuminate\Database\Eloquent\Model;

class Video extends Model{
    protected $table = 'professional_videos';

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }

    public static function formatage($url){
    	$parts = explode('?v=', $url);
        $url = (count($parts) > 1) ? $parts[1] : $parts[0];
        $parts = explode('&', $url);
        return $parts[0];
    }
}
