<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use App\Models\Professional;
use App\Models\Company;
use App\Models\Tools\Tools;

class CompanyRepository implements RepositoryInterface
{

    protected $company;

    const PAGINATE = 2;

	public function __construct(Company $company){
		$this->company = $company;
	}

	public function save($datas){	
		$this->company->professional_id = $datas['professional_id'];
		$this->company->metier_id = $datas['metier_id'];
    	$this->company->address_id = $datas['address_id'];
    	$this->company->name = $datas['name'];
    	$this->company->slug = $datas['slug'];
     	$this->company->description = $datas['description'];
    	$this->company->tva_number = $datas['tva_number'];
    	$this->company->status = 10;
        $this->company->save();
        return $this->company;
	}

	public function update($datas){
		$user_id = Auth::id();
		$this->company->where('user_id', '=', $user_id)->first();
		$this->company->category_id = $datas['category_id'];
		$this->company->save();
	}

	public function getById($id){
		return $this->company->findOrFail($id);
	}

	public function getAll(){
		return $this->company->all();
	}	

	public function getAllForPaginate(){
		return $this->company->paginate(self::PAGINATE);
	}

	public function getByUser($user_id = null){
		if($user_id == null){
			$user_id = Auth::id();
		}		
		return $this->company->where('user_id', '=', $user_id)->first();
	}

	/*public function getByCity($city){
		return $this->company->select('*')->join('address', 'address.id', '=', 'companies.address_id')
					->where('address.city', '=', $city)->paginate(self::PAGINATE);
	}*/

	public function getByCities($cities){
		return $this->company->select('*')->join('address', 'address.id', '=', 'companies.address_id')
					->whereIn('address.city', $cities)->paginate(self::PAGINATE);
	}

	/*public function getByMetierAndCity($metier_id, $city){
		return $this->company->select('companies.*')
					->join('address', 'address.id', '=', 'companies.address_id')
					//->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->where('address.city', '=', $city)->where('companies.metier_id', '=', $metier_id)->paginate(self::PAGINATE);;
	}*/

	public function getByMetierAndCities($metier_id, $cities){

		return $this->company->select('companies.*')
					->join('address', 'address.id', '=', 'companies.address_id')
					//->join('metiers', 'metiers.id', '=', 'professional_metier.metier_id')
					->whereIn('address.city', $cities)->where('companies.metier_id', '=', $metier_id)->get();
	}

	public function getByMetierSlugAndCity($metier, $city){
		return $this->company->select('companies.*')
					->join('address', 'address.id', '=', 'companies.address_id')					
					->join('metiers', 'metiers.id', '=', 'companies.metier_id')
					->where('address.city', '=', $city)->where('metiers.slug', '=', $metier)->paginate(self::PAGINATE);
	}

	

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
		return $this->company->select('companies.*')
					->where('companies.metier_id', '=', $metier_id)
					->where('companies.name', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}

	public function getByMetierAndCityAndName($metier_id, $city, $name){
		return $this->company->select('companies.*')
					->join('address', 'address.id', '=', 'companies.address_id')
					->where('address.city', '=', $city)->where('companies.metier_id', '=', $metier_id)
					->where('companies.name', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}*/

	

	public function getByStatus($status){
		return $this->company->where('status', '=', $status)->paginate(self::PAGINATE);
	}

	/*public function getByMetier($metier_id){		
		return $this->company->select('companies.*')									
					->where('companies.metier_id', $metier_id)					
     				->paginate(self::PAGINATE);
	}*/

	public function getByOptions($options, $count = false){
		$query = Company::query();		
		if(isset($options['city'])){
			$query->join('address', 'address.id', '=', 'companies.address_id');
		}
		if(isset($options['metier'])){
			$query->where('companies.metier_id', $options['metier']);
		}
		if(isset($options['city'])){
			$query->where('address.city', '=', $options['city']);
		}
		if(isset($options['name'])){
			$query->where('companies.name', 'LIKE', '%' . $options['name'] . '%');
		}
		return ($count) ? $query->count() : $query->paginate(self::PAGINATE);
	}

	public function getByMetiers($metiers){
		$n = count($metiers);
		$results = $this->company->select('companies.id')
					->join('metiers', 'metiers.id', '=', 'companies.metier_id')
					->whereIn('companies.metier_id', $metiers)
					->groupBy('companies.id')
					->havingRaw("COUNT(DISTINCT companies.metier_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->company->select('companies.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	public function getBySkillsAndOptions($skills, $options, $count = false){
		$n = count($skills);

		$query = $this->company->select('companies.id')
					->join('professional_metier_skill', 'companies.professional_id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id');	

		if(isset($options['city'])){
			$query->join('address', 'address.id', '=', 'companies.address_id');
			$query->where('address.city', '=', $options['city']);
		}
		if(isset($options['name'])){
			$query->where('companies.name', 'LIKE', '%' . $options['name'] . '%');
		}

		$results = $query->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('companies.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				->get();

     	if($count){
			return count($results);
		}

		$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->company->select('companies.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	/*public function getBySkillsAndCityAndName($skills, $city, $name){
		$n = count($skills);
		$results = $this->company->select('companies.id')
					->join('professional_metier_skill', 'companies.professional_id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->join('address', 'address.id', '=', 'companies.address_id')
					->where('address.city', '=', $city)
					->where('companies.name', 'LIKE', '%' . $name . '%')
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('companies.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->company->select('companies.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}

	public function getBySkillsAndCity($skills, $city){
		$n = count($skills);
		$results = $this->company->select('companies.id')
					->join('professional_metier_skill', 'companies.professional_id', '=', 'professional_metier_skill.professional_id')
					->join('metier_skills', 'metier_skills.id', '=', 'professional_metier_skill.skill_id')
					->join('address', 'address.id', '=', 'companies.address_id')
					->where('address.city', '=', $city)
					->whereIn('professional_metier_skill.skill_id', $skills)
					->groupBy('companies.id')
					->havingRaw("COUNT(DISTINCT professional_metier_skill.skill_id) = ".$n)
     				//->having('count(distinct professional_metier_skill.skill_id)', '=', $n)
     				->get();
     	$ids = array();
     	foreach ($results as $result) {
     		array_push($ids, $result->id);
     	}
     	return $this->company->select('companies.*')
					->whereIn('id', $ids)->paginate(self::PAGINATE);
	}*/



}