<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

use App\Models\Address;

class AddressRepository implements RepositoryInterface
{

    protected $address;

	public function __construct(Address $address){
		$this->address = $address;
	}

	public function save($datas){	
					
        $this->address->country = $datas['country'];
        $this->address->city = $datas['city'];
        $this->address->postal_code = $datas['postalcode'];
        $this->address->street = $datas['street'];
        $this->address->setPosition();
        $this->address->save();
        return $this->address;
	}

	public function getById($id){
		return $this->address->findOrFail($id);
	}

	public function getAll(){
		return $this->address->all();
	}

}