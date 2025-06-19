<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

use App\Models\Professional;
use App\Models\Address;
use App\Models\Message;
use App\Models\User\Setting;

use App\Repositories\ProfessionalRepository;
use App\Repositories\AddressRepository;
use App\Repositories\MessageRepository;
use App\Repositories\User\SettingRepository;

class User extends Authenticatable implements MustVerifyEmail
{    

    use Notifiable;
    
    protected $fillable = [
        'name', 'firstname', 'email', 'tel', 'type', 'password', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function professional(){
        return $this->belongsTo('App\Models\Professional');
    }

    public function settings(){
        return $this->hasMany('App\Models\User\Setting');
    }

    public function projects(){
        return $this->hasMany('App\Models\Project');
    }

    public function getProfessional(){
        $professionalRepository = new ProfessionalRepository(new Professional());
        return $professionalRepository->getByUser($this->id);
    }

    public function isProfessional(){
        $professionalRepository = new ProfessionalRepository(new Professional());
        return (is_null($professionalRepository->getByUser($this->id))) ? false : true;
    }

    public function getAddress(){
        $addressRepository = new AddressRepository(new Address());
        return $addressRepository->getById($this->address_id);
    }

    public function isAdmin(){
        return ($this->type === 'ADMIN') ? true : false;
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

    public function getCountMessagesNotView(){
        $messageRepository = new MessageRepository(new Message());
        return $messageRepository->countUnread();
    }

    public function getMessagesRecipient(){
        $messageRepository = new MessageRepository(new Message());
        return $messageRepository->getAllByRecipient($this->id);
    }

    public function getAverageReplyGap(){
        $total = 0;
        $cpt = 0;
        foreach ($this->getMessagesRecipient() as $message) {
            $gap = $message->getReplyGap();
            if($gap){
                $total += $gap;
                $cpt++;
            }
        }
        return ($cpt > 0) ? round($total/$cpt) : false;            
    }
}
