<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Professional;
use App\Models\Company;
use App\Models\Hall;
use App\Models\Tools\Tools;
use App\Models\User\Interaction;

use App\Repositories\ProfessionalRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\HallRepository;
use App\Repositories\AdviceRepository;
use App\Repositories\User\InteractionRepository;

class Advice extends Model{
	
    protected $table = 'advices';
    
    const OBJECT_PROFESSIONAL = 'professional';
    const OBJECT_HALL = 'hall';
    const OBJECT_COMPANY = 'company';

    const SCORE_MIN = 1;
    const SCORE_MAX = 5;

    const CANCELED = 0;
    const REPORTED   = 5;
    const POSTED  = 10;
    const VERIFIED = 20;

    public static $status = [     
        self::CANCELED,
        self::REPORTED,
        self::POSTED,
        self::VERIFIED        
    ];

    public static $types = [
        self::OBJECT_PROFESSIONAL,
        self::OBJECT_HALL,
        self::OBJECT_COMPANY
    ];

    public function user(){
      return $this->belongsTo('App\Models\User');
    } 

    public static function getAverage($advices){
        if(count($advices) > 0){
            $total = $n = 0;
            foreach ($advices as $advice) {
                $total += $advice->score;
                $n++;
            }
            return $total/$n;
        }
        else{
            return '-';
        }
    }

    public function getObject(){
    	if($this->type == self::OBJECT_PROFESSIONAL){
          $professionalRepository = new ProfessionalRepository(new Professional);
          return $professionalRepository->getById($this->object_id);
        }
        if($this->type == self::OBJECT_COMPANY){
          $companyRespository = new CompanyRepository(new Company);
          return $companyRespository->getById($this->object_id);
        }
        if($this->type == self::OBJECT_HALL){
          $hallRespository = new HallRepository(new Hall);
          return $hallRespository->getById($this->object_id);
        }
    }

    public function getIntervalDate(){
        $date_post = strtotime($this->created_at);
        $now   = time();
        $diff = Tools::dateDiff($now, $date_post);
        if($diff['day'] > 0){
            return __('there_is').' '.$diff['day'].' '.__('days');
        }
        elseif($diff['hour'] > 0){
            return __('there_is').' '.$diff['hour'].' '.__('hours');
        }
        elseif($diff['minute'] > 0){
            return __('there_is').' '.$diff['minute'].' '.__('minutes');
        }
        else{
            return __('just_now');
        }
    }

    public function getUpVote(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_ADVICE], ['type', '=', Interaction::TYPE_VOTE], ['value', '=', 1]])->count();
    }

    public function getDownVote(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_ADVICE], ['type', '=', Interaction::TYPE_VOTE], ['value', '=', -1]])->count();
    }

    public function isVoted($user_id, $val){
        $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_ADVICE],['type', '=', Interaction::TYPE_VOTE], ['value', '=', $val]])->first();
        return (is_null($interaction)) ? false : true;
    }

}