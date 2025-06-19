<?php

namespace App\Models\Metier;

use Illuminate\Database\Eloquent\Model;

use App\Models\Professional;

use App\Repositories\ProfessionalRepository;

class Skill extends Model{
	
    protected $table = 'metier_skills';

    public function metier(){
      return $this->belongsTo('App\Models\Metier');
    }

    public function professionals(){
        return $this->belongsToMany('App\Models\Professional', 'professional_metier_skill');
    } 

    public function getProfessionalCount(){
        $professionalRepository = new ProfessionalRepository(new Professional());
        return $professionalRepository->getCountBySkill($this->id);
    }
}