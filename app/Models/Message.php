<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

use App\Repositories\ProfessionalRepository;
use App\Repositories\UserRepository;

class Message extends Model{
	
    protected $table = 'messages';
    public $timestamps = false; 

    public function user(){
      return $this->belongsTo('App\Models\User');
    }

    public function message(){
      return $this->belongsTo('App\Models\Message');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }

    public function getRecipient(){
    	$userRepository = new UserRepository(new Message());
    	return $userRepository->getById($this->recipient_id);
    }

    public function getSender(){
    	$userRepository = new UserRepository(new User());
    	return $userRepository->getById($this->sender_id);
    }

    public function getReplyGap(){
        if(!is_null($this->response_time)){
            $send_time = strtotime($this->send_time);
            $response_time = strtotime($this->response_time);
            return abs($send_time - $response_time);
        }
        else{
            return false;
        }        
    }

    public static function unread(){

    }

}