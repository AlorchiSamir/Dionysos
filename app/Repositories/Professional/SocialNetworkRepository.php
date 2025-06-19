<?php

namespace App\Repositories\Professional;

use App\Repositories\RepositoryInterface;

use App\Models\Professional\SocialNetwork;

class SocialNetworkRepository implements RepositoryInterface
{

    protected $social_network;

	public function __construct(SocialNetwork $social_network){
		$this->social_network = $social_network;
	}

	public function save($datas){
        $this->social_network->url = $datas['url'];
        $this->social_network->network = $datas['network'];
        $this->social_network->professional_id = $datas['professional_id'];
        $this->social_network->order = 1;
        $this->social_network->save();
	}

	public function getById($id){
		return $this->social_network->findOrFail($id);
	}

	public function getAll(){
		return $this->social_network->all();
	}

	public function getByNetwork($network, $professional_id){
		return $this->social_network->where('professional_id', '=', $professional_id)->where('network', '=', $network)->first();
	}
	
}