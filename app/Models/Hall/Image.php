<?php

namespace App\Models\Hall;

use Illuminate\Database\Eloquent\Model;

class Image extends Model{
    protected $table = 'hall_images';
    public $timestamps = false; /* A ENLEVER */

    const REFUSED   = '1';
    const WAITING   = '10';
    const VALIDATED = '20';

    public static $status = [
        self::REFUSED,
        self::WAITING,
        self::VALIDATED
    ];

    public function hall(){
    	return $this->belongsTo('App\Models\Hall');
    }
}
