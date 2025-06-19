<?php

namespace App\Repositories\Professional;

use App\Repositories\RepositoryInterface;

use App\Models\Professional\Price;

class PriceRepository implements RepositoryInterface
{

    protected $price;

	public function __construct(Price $price){
		$this->price = $price;
	}

	public function save($datas){
        $this->price->price = $datas['price'];
        $this->price->type = $datas['type'];
        $this->price->professional_id = $datas['professional_id'];
        $this->price->active = true;
        $this->price->save();
	}

	public function getById($id){
		return $this->price->findOrFail($id);
	}

	public function getAll(){
		return $this->price->all();
	}

	public function getActivePrice($professional_id){
		return $this->price->where('professional_id', '=', $professional_id)->where('active', '=', 1)->first();
	}

}