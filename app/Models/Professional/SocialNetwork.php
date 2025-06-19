<?php

namespace App\Models\Professional;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model{
    protected $table = 'professional_social_networks';

    const FACEBOOK    = 'facebook';
    const TWITTER = 'twitter';
    const INSTAGRAM = 'instagram';
    const TIKTOK = 'tiktok';

    public static $networks = [
        self::FACEBOOK,
        self::TWITTER,
        self::INSTAGRAM,
        self::TIKTOK
    ];

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }
}