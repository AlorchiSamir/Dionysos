<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

use App\Models\Professional;
use App\Models\User;
use App\Models\Address;
use App\Models\Advice;
use App\Models\Professional\Setting;
use App\Models\Price;
use App\Models\User\Interaction;
use App\Models\Tools\Tools;

use App\Repositories\ProfessionalRepository;
use App\Repositories\AddressRepository;
use App\Repositories\AdviceRepository;
use App\Repositories\Professional\SettingRepository;
use App\Repositories\PriceRepository;

class Professional extends Model
{
    protected $table = 'professionals';

    const STEP_1    = '1';
    const STEP_2    = '2';
    const STEP_3    = '3';
    const STEP_4    = '4';
    const WAITING   = '10';
    const VALIDATED = '20';
    const VERIFIED  = '30';

    public static $status = [
        self::STEP_1,
        self::STEP_2,
        self::STEP_3,
        self::STEP_4,
        self::WAITING,
        self::VALIDATED,
        self::VERIFIED
    ];

    public function user(){
      return $this->belongsTo('App\Models\User');
    }

    public function company(){
        return $this->belongsToMany('App\Models\Company');
    }

    public function metiers(){
        return $this->belongsToMany('App\Models\Metier', 'professional_metier');
    }  

    public function skills(){
        return $this->belongsToMany('App\Models\Metier\Skill', 'professional_metier_skill');
    }  

    public function settings(){
        return $this->hasMany('App\Models\Professional\Setting');
    } 

    public function videos(){
        return $this->hasMany('App\Models\Professional\Video');
    }

    public function prices(){
        return $this->hasMany('App\Models\Professional\Price');
    } 

    public function address(){
        return $this->belongsTo('App\Models\Address');
    }

    public function halls(){
        return $this->hasMany('App\Models\Hall');
    }

    public function social_networks(){
        return $this->hasMany('App\Models\Professional\SocialNetwork');
    }

    public function getAddress(){
        Address::getCitiesAround();
    	$addressRepository = new AddressRepository(new Address());
        if(is_null($this->address_id)){
            return false;
        }
    	return $addressRepository->getById($this->address_id);
    }

    public function getAllSettings(){
        $results = $this->settings;
        $array = array();
        foreach ($results as $result){
          $array[$result->setting] = $result->value;
        }
        $diff = array_diff(Setting::$settings, array_keys($array));
        foreach ($diff as $value) {
            $array[$value] = Setting::$defaults[$value];
        }
        return $array;
    }

    public function getSetting($query){
        if(in_array($query, Setting::$settings)){
            $settingRepository = new SettingRepository(new Setting());
            $setting = $settingRepository->getBySetting($query, $this->id);
            if(is_null($setting)){
                return Setting::$defaults[$query];
            }
            return $setting->value;
        }
        return false;       
    }

    public function getCurrentPrice(){
        $priceRepository = new PriceRepository(new Price());
        return $priceRepository->getActivePrice($this->id, 'professional');
    }	

    public function getAdvices(){
        $adviceRepository = new AdviceRepository(new Advice());  
        return $adviceRepository->getByObjectAndType($this->id, 'professional');
    }  

    public function getAdviceByCurrentUser(){
        $adviceRepository = new AdviceRepository(new Advice());
        return $adviceRepository->getByObjectAndCurrentUser($this->id, 'professional');
    }

    public function getAverageScore(){
        $adviceRepository = new AdviceRepository(new Advice());
        $scores = count($adviceRepository->getByObjectAndType($this->id, 'professional'));
        $total = $adviceRepository->getSumOfScore($this->id, 'professional');
        return ($scores > 0) ? $total/$scores : null;       
    }

	public static function getCurrent(){
		$user_id = Auth::id();
        $professionalRepository = new ProfessionalRepository(new Professional());
		return $professionalRepository->getByUser($user_id);
	}

    public function isLiked($user_id){
      $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_PROFESSIONAL],['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function isInterested($user_id){
      $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_PROFESSIONAL], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->first();
      return (is_null($interaction)) ? false : true;
    }

    public function getLikes(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_PROFESSIONAL], ['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->count();
    }

    public function getInterests(){
        return Interaction::where([['object_id', '=', $this->id], ['object_type', '=', 
                     Interaction::OBJECT_PROFESSIONAL], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->count();
    }

    public function isNew(){
        $diff = Tools::dateDiff($this->created_at);
        return ($diff['day'] < 7) ? true : false;
    }

    public function getSocialNetworksInArray(){
        $social_networks = $this->social_networks;
        $networks = array();
        foreach ($social_networks as $social_network) {
            $networks[$social_network->network] = $social_network->url;
        }
        return $networks;
    }

    public function isHallOwner(){
        return (isset($this->metiers[0]) && $this->metiers[0]->name == Metier::HALL_OWNER) ? true : false;
    }


}
