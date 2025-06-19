<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use App\Models\Professional;
use App\Models\Metier;
use App\Models\User;
use App\Models\Address;
use App\Models\Tools\Tools;

use App\Repositories\UserRepository;
use App\Repositories\AddressRepository;
use App\Repositories\MetierRepository;

class ProfessionalRepository implements RepositoryInterface
{

    protected $professional;

    const PAGINATE = 2;

	public function __construct(Professional $professional){
		$this->professional = $professional;
	}

	public function save($datas){	
		$user = $datas['user'];	
        $this->professional->user_id = $user->id;
        $this->professional->surname = $user->firstname.' '.$user->name;
        $this->professional->slug = Tools::Slugify( $this->professional->surname);
        $this->professional->tel = $user->tel;
        $this->professional->email = $user->email;
        $this->professional->address_id = null;
        $this->professional->status = 1;
        $this->professional->description = null;
        $this->professional->website = null;
        $this->professional->save();
        //$this->professional->metiers()->attach(1);
        return $this->professional;
	}

	public function update($datas){
		$user_id = Auth::id();
		$this->professional->where('user_id', '=', $user_id)->first();
		$this->professional->category_id = $datas['category_id'];
		$this->professional->save();
	}

	public function getById($id){
		return $this->professional->findOrFail($id);
	}

	public function getAll(){
		return $this->professional->all();
	}	

	public function getAllForPaginate(){
		return $this->professional->paginate(self::PAGINATE);
	}

	public function getAllExcept($metier){
		return $this->professional->select('professionals.*')					
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('metiers.name', '!=', $metier)->paginate(self::PAGINATE);
	}

	public function getAllByType($type){
		return $this->professional->select('professionals.*')					
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('metiers.type', '=', $type)->paginate(self::PAGINATE);
	}

	public function getByUser($user_id = null){
		if($user_id == null){
			$user_id = Auth::id();
		}		
		return $this->professional->where('user_id', '=', $user_id)->first();
	}

	/*public function getByCity($city){
		return $this->professional->select('*')->join('address', 'address.id', '=', 'professionals.address_id')
					->where('address.city', '=', $city)->paginate(self::PAGINATE);;
	}*/

	public function getByCities($cities){
		return $this->professional->select('*')->join('address', 'address.id', '=', 'professionals.address_id')
					->whereIn('address.city', $cities)->paginate(self::PAGINATE);;
	}

	/*public function getByMetierAndCity($metier_id, $city){
		return $this->professional->select('professionals.*')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					//->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('address.city', '=', $city)->where('professional_metier.metier_id', '=', $metier_id)->paginate(self::PAGINATE);;
	}*/

	public function getByMetierAndCities($metier_id, $cities){

		return $this->professional->select('professionals.*')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					//->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->whereIn('address.city', $cities)->where('professional_metier.metier_id', '=', $metier_id)->get();
	}

	public function getByMetierSlugAndCity($metier, $city){
		return $this->professional->select('professionals.*')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('address.city', '=', $city)->where('metiers.slug', '=', $metier)->paginate(self::PAGINATE);
	}

	public function getByStatus($status){
		return $this->professional->where('status', '=', $status)->paginate(self::PAGINATE);
	}

	/*public function getByMetier($metier_id){		
		return $this->professional->select('professionals.*')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')					
					->where('professional_metier.metier_id', $metier_id)					
     				->paginate(self::PAGINATE);
	}*/

	public function getByMetiers($metiers){
		$n = count($metiers);
		$results = $this->professional->select('professionals.id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->whereIn('professional_metier.metier_id', $metiers)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier.metier_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	public function getBySkill($skill_id){
		return $this->professional->select('professionals.*')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->where('professional_metier_skill.skill_id', $skill_id)
     				->paginate(self::PAGINATE);
	}

	public function getBySkills($skills){
		$n = count($skills);
		$results = $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	/*public function getBySkillsAndCity($skills, $city){
		$n = count($skills);
		$results = $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->where('address.city', '=', $city)
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}*/

	public function getBySkillsAndCities($skills, $cities){

		$n = count($skills);
		$results = $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->whereIn('address.city', $cities)
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->get();
	}

	/*public function getByMetierAndName($metier_id, $name){
		return $this->professional->select('professionals.*')					
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->where('professional_metier.metier_id', '=', $metier_id)
					->where('professionals.surname', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}

	public function getByMetierAndCityAndName($metier_id, $city, $name){
		return $this->professional->select('professionals.*')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					//->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('address.city', '=', $city)->where('professional_metier.metier_id', '=', $metier_id)
					->where('professionals.surname', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}*/

	/*public function getBySkillsAndCityAndName($skills, $city, $name){
		$n = count($skills);
		$results = $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->join('address', 'address.id', '=', 'professionals.address_id')
					->where('address.city', '=', $city)
					->where('professionals.surname', 'LIKE', '%' . $name . '%')
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}*/

	public function getByOptions($options, $count = false){
		$query = Professional::query();
		if(isset($options['metier'])){
			$query->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id');
		}
		if(isset($options['city'])){
			$query->join('address', 'address.id', '=', 'professionals.address_id');
		}
		if(isset($options['metier'])){
			$query->where('professional_metier.metier_id', '=', $options['metier']);
		}
		if(isset($options['city'])){
			$query->where('address.city', '=', $options['city']);
		}
		if(isset($options['name'])){
			$query->where('professionals.surname', 'LIKE', '%' . $options['name'] . '%');
		}
		return ($count) ? $query->count() : $query->paginate(self::PAGINATE);
	}

	public function getBySkillsAndOptions($skills, $options, $count = false){
		$n = count($skills);

		$query = $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id');

		if(isset($options['city'])){
			$query->join('address', 'address.id', '=', 'professionals.address_id');
			$query->where('address.city', '=', $options['city']);
		}
		if(isset($options['name'])){
			$query->where('professionals.surname', 'LIKE', '%' . $options['name'] . '%');
		}

		$results = $query->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('professionals.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)->get();

		if($count){
			return count($results);
		}

		$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->professional->select('professionals.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	public function getCountByMetier($metier_id){
		return $this->professional->select('professionals.id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('professional_metier.metier_id', $metier_id)
					->groupBy('professionals.id')
     				->get()->count();
	}

	public function getCountBySkill($skill_id){
		return $this->professional->select('professionals.id')
					->join('professional_metier_skill', 'professionals.id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->where('professional_metier_skill.skill_id', $skill_id)
					->groupBy('professionals.id')
     				->get()->count();
	}

	public function getCountByType($type){
		return $this->professional->select('professionals.id')
					->join('professional_metier', 'professionals.id', '=', 'professional_metier.professional_id')
					->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('metiers.type', $type)
					->groupBy('professionals.id')
     				->get()->count();
	}

	public function saveMetier($metier_id){
		$professionalMetier = new Professional_Metier();
		$professional = Professional::getCurrent();        
		$professionalMetier->professional_id = $professional->id;
		$professionalMetier->metier_id = $metier_id;
		$professionalMetier->timestamps = false;
		$professionalMetier->save();
	}	

}