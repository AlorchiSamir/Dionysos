<?php

namespace App\Repositories\Metier;

use App\Repositories\RepositoryInterface;

use App\Models\Professional;
use App\Models\Professional\Metier;
use App\Models\Metier\Skill;

class SkillRepository implements RepositoryInterface
{

    protected $skill;

	public function __construct(Skill $skill){
		$this->skill = $skill;
	}

	public function save($datas){
		$this->skill->metier_id = $datas['metier_id'];
        $this->skill->name = $datas['name'];
        $this->skill->color = $datas['color'];
        //$this->skill->slug = $datas['slug'];
        $this->skill->save();
	}

	public function getById($id){
		return $this->skill->findOrFail($id);
	}

	public function getAll(){
		return $this->skill->all();
	}

	public function getByMetier($metier_id){
		$skills = $this->skill->where('metier_id', '=', $metier_id)->get();
		$array = array();
		foreach ($skills as $skill) {
			$array[$skill->id] = $skill;
		}
		return $array;
	}

	public function saveProfessionalMetierSkill($metier_id, $skill_id){
		$professionalMetierskill = new Professional_Metier_skill();
		$professional = Professional::getCurrent();
        $professionalMetier = new Metier();
        $professionalMetier = $professionalMetier->where('professional_id', '=', $professional->id)->where('metier_id', '=', $metier_id)->first();
		$professionalMetierskill->professionals_metiers_id = $professionalMetier->id;
		$professionalMetierskill->skill_id = $skill_id;
		$professionalMetierskill->timestamps = false;
		$professionalMetierskill->save();
	}	

	public function getByProfessional($id){
		$metier_skill = new Professional_Metier_skill();
		$professional_metier = new Professional_Metier();
		$professional_metier = $professional_metier->where('professional_id', '=', $id)->first();
		$results = $metier_skill->where('professionals_metiers_id', '=', $professional_metier->id)->get();
		$skills = array();
		foreach ($results as $result) {			
			array_push($skills, $this->getById($result->skill_id));			
		}
		return $skills;
	}

}