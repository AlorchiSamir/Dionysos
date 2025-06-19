<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Advice;
use App\Models\User\Interaction;
use App\Models\Tools\Tools;

use App\Repositories\AdviceRepository;
use App\Repositories\PriceRepository;

class Hall extends Model{
	
    protected $table = 'halls';

    const OBJECT_NAME = 'hall';

    public function images(){
        return $this->hasMany('App\Models\Hall\Image');
    }

    public function professional(){
    	return $this->belongsTo('App\Models\Professional');
    }

    public function address(){
        return $this->belongsTo('App\Models\Address');
    }

    public function prices(){
        return $this->hasMany('App\Models\Price');
    } 

    public function getCurrentPrice(){
        $priceRepository = new PriceRepository(new Price());
        return $priceRepository->getActivePrice($this->id, self::OBJECT_NAME);
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
                     Interaction::OBJECT_HALL],['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function isInterested($user_id){
      $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_HALL], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function getLikes(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_HALL], ['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->count();
    }

    public function getInterests(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_HALL], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->count();
    }

    public function isNew(){
        $diff = Tools::dateDiff($this->created_at);
        return ($diff['day'] < 7) ? true : false;
    }

    public function getFrontImage(){
        return 'default.jpg';
    }
   
}