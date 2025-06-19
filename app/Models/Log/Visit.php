<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model{
	
    protected $table = 'log_visits';

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

}