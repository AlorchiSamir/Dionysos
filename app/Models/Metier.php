<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Professional;

use App\Repositories\ProfessionalRepository;

class Metier extends Model{
	
    protected $table = 'metiers';

    const DEEJAY     = 'deejay';
    const BARMAN     = 'barman';
    const HALL_OWNER = 'hall_owner';

    const TYPE_PERSON  = 'person';
    const TYPE_COMPANY = 'company';
    const TYPE_PLACE   = 'place';

    public static $metiers = [
        self::DEEJAY,
        self::BARMAN,
        self::HALL_OWNER,
    ];

    public static $classics = [
        self::DEEJAY,
        self::BARMAN
    ];

    public static $types = [
        self::TYPE_PERSON,
        self::TYPE_COMPANY,
        self::TYPE_PLACE
    ];

    public function professionals(){
        return $this->belongsToMany('App\Models\Professional', 'professional_metier');
    } 

    public function skills(){
        return $this->hasMany('App\Models\Metier\Skill');
    }

    public function getProfessionalCount(){
        $professionalRepository = new ProfessionalRepository(new Professional());
        return $professionalRepository->getCountByMetier($this->id);
    }
}