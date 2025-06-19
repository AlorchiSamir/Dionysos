<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model{
    protected $table = 'prices';

    const HOUR    = 'hour';
    const FORFAIT = 'forfait';

    public static $types = [
        self::HOUR,
        self::FORFAIT
    ];

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }

    public function hall(){
        return $this->belongsTo('App\Models\Hall');
    }
}