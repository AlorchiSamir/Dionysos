<?php

namespace App\Models\Professional;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'professional_settings';

    const AVATAR = 'avatar';
    const DISTANCE = 'distance';
    const ACCEPT_ADVICE = 'accept_advice';

    public static $settings = [
    	self::AVATAR,
    	self::DISTANCE,
        self::ACCEPT_ADVICE
  	];

    public static $defaults = [
        self::AVATAR => 'default.jpg',
        self::DISTANCE => 0,
        self::ACCEPT_ADVICE => true
    ];

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }
}
