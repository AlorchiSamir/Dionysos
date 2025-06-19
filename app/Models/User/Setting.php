<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'user_settings';

    const AVATAR = 'avatar';
    const SEARCH = 'search';

    public static $settings = [
    	self::AVATAR,
        self::SEARCH
  	];

    public static $defaults = [
        self::AVATAR => 'default.jpg',
        self::SEARCH => 'empty'
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
}