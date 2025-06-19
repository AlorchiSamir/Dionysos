<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Advice;
use App\Models\User\Interaction;
use App\Models\Tools\Tools;

use App\Repositories\AdviceRepository;

class Company extends Model{
    protected $table = 'companies';

    const OBJECT_NAME = 'company';

    const WAITING   = '10';
    const VALIDATED = '20';
    const VERIFIED  = '30';

    public static $status = [
        self::WAITING,
        self::VALIDATED,
        self::VERIFIED
    ];

    public function address(){
        return $this->belongsTo('App\Models\Address');
    }

    public function metier(){
        return $this->belongsTo('App\Models\Metier');
    }

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }

    public function getAdvices(){
        $adviceRepository = new AdviceRepository(new Advice());  
        return $adviceRepository->getByObjectAndType($this->id, self::OBJECT_NAME);
    }

    public function getAdviceByCurrentUser(){
        $adviceRepository = new AdviceRepository(new Advice());
        return $adviceRepository->getByObjectAndCurrentUser($this->id, self::OBJECT_NAME);
    }

    public function getAverageScore(){
        $adviceRepository = new AdviceRepository(new Advice());
        $scores = count($adviceRepository->getByObjectAndType($this->id, self::OBJECT_NAME));
        $total = $adviceRepository->getSumOfScore($this->id, self::OBJECT_NAME);
        return ($scores > 0) ? $total/$scores : null;       
    }

    public function isLiked($user_id){
      $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_COMPANY],['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function isInterested($user_id){
      $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_COMPANY], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function getLikes(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_COMPANY], ['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->count();
    }

    public function getInterests(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_COMPANY], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->count();
    }

    public function isNew(){
        $diff = Tools::dateDiff($this->created_at);
        return ($diff['day'] < 7) ? true : false;
    }
   
}