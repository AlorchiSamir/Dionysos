<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Models\Hall;

class HallRepository implements RepositoryInterface
{

    protected $hall;

    const PAGINATE = 1;

	public function __construct(Hall $hall){
		$this->hall = $hall;
	}

	public function save($datas){	
					
        $this->hall->professional_id = $datas['professional_id'];
    	$this->hall->address_id = $datas['address_id'];
    	$this->hall->name = $datas['name'];
    	$this->hall->slug = $datas['slug'];
     	$this->hall->description = $datas['description'];
    	$this->hall->capacity = $datas['capacity'];
    	$this->hall->parking = $datas['parking'];
        $this->hall->save();
        return $this->hall;
	}

	public function getById($id){
		return $this->hall->findOrFail($id);
	}

	public function getAll(){
		return $this->hall->paginate(self::PAGINATE);
	}

	public function getByCity($city){
		return $this->hall->select('halls.*')->join('address', 'address.id', '=', 'halls.address_id')
					->where('address.city', '=', $city)->paginate(self::PAGINATE);
	}

	public function getByCityAndName($city, $name){
		return $this->hall->select('halls.*')->join('address', 'address.id', '=', 'halls.address_id')
					->where('address.city', '=', $city)
					->where('halls.name', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}

	public function getByName($name){
		return $this->hall->select('halls.*')->where('halls.name', 'LIKE', '%' . $name . '%')->paginate(self::PAGINATE);
	}

	public function getByOptions($options, $count = false){
		$query = Hall::query();
		
		if(isset($options['city'])){
			$query->join('address', 'address.id', '=', 'halls.address_id');	
			$query->where('address.city', '=', $options['city']);
		}
		if(isset($options['name'])){
			$query->where('halls.name', 'LIKE', '%' . $options['name'] . '%');
		}
		return ($count) ? $query->count() : $query->paginate(self::PAGINATE);
	}

	public function getByCities($cities, $limit = 10){
		return $this->hall->select('halls.*')->join('address', 'address.id', '=', 'halls.address_id')
					->whereIn('address.city', $cities)->take($limit)->get();
	}

	public function getCount(){
		return $this->hall->get()->count();
	}

}