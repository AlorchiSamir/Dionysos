<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

use App\Models\Professional;
use App\Models\Metier;
use App\Models\Professional\Metier as Professional_Metier;

class MetierRepository implements RepositoryInterface
{

    protected $metier;

	public function __construct(Metier $metier){
		$this->metier = $metier;
	}

	public function save($datas){
        $this->metier->name = $datas['name'];
        $this->metier->color = $datas['color'];
        $this->metier->save();
	}

	public function getById($id){
		return $this->metier->findOrFail($id);
	}

	public function getAll(){
		return $this->metier->all();
	}

	public function getInArrayByType(){
		$types = Metier::$types;
		$metiers = array();
		foreach ($types as $type) {
			$results = $this->getByType($type);
			foreach ($results as $result) {
				$metiers[$type][] = $result;
 			}
		}
		return $metiers;
	}

	public function getByType($type){
		return $this->metier->where('type', '=', $type)->get();
	}

	public function getAllExcept($metier){
		return $this->metier->select('*')->where('name', '!=', $metier)->get();
	}

	public function getByName($name){
		return $this->metier->where('name', '=', $name)->first();
	}
	

}