<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

use App\Models\Price;

class PriceRepository implements RepositoryInterface
{

    protected $price;

	public function __construct(Price $price){
		$this->price = $price;
	}

	public function save($datas){
        $this->price->price = $datas['price'];
        $this->price->type = $datas['type'];
        $this->price->professional_id = (isset($datas['professional_id'])) ?  $datas['professional_id'] : null;
        $this->price->hall_id = (isset($datas['hall_id'])) ? $datas['hall_id'] : null;
        $this->price->active = true;
        $this->price->save();
	}

	public function getById($id){
		return $this->price->findOrFail($id);
	}

	public function getAll(){
		return $this->price->all();
	}

	public function getActivePrice($object_id, $type){
		if($type == 'professional'){
			return $this->price->where('professional_id', '=', $object_id)->where('active', '=', 1)->first();
		}
		if($type == 'hall'){
			return $this->price->where('hall_id', '=', $object_id)->where('active', '=', 1)->first();
		}		
	}

}