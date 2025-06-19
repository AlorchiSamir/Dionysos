<?php

namespace App\Repositories\Log;

use Illuminate\Support\Facades\Auth;

use App\Repositories\RepositoryInterface;

use App\Models\Log\Visit;

class VisitRepository implements RepositoryInterface
{

  protected $visit;
  protected $user;

	public function __construct(Visit $visit){
		$this->visit = $visit;      
	}

	public function save($datas){
    	$this->visit->user_id = $datas['user_id'];
    	$this->visit->object_type = $datas['object_type'];
    	$this->visit->object_id = $datas['object_id'];
    	$this->visit->count = $datas['count'];
    	$this->visit->save();
	}

	public function delete($id){
		return $this->visit->destroy($id);
	}

	public function getById($id){
		return $this->visit->findOrFail($id);
	}

	public function getByCurrentUser(){
		return $this->visit->where('user_id', '=', $this->user_id)->get();
	}

	public function getByObject($type, $object_type){
    return $this->visit->where('user_id', '=', $this->user_id)->where('object_id', '=', $object_id)
                             ->where('object_type', '=', $object_type)->get();
  	}

  	public function getByUserAndObject($user_id, $object_type, $object_id){
  		return $this->visit->where('user_id', '=', $user_id)->where('object_type', '=', $object_type)
                             ->where('object_id', '=', $object_id)->first();
  	}
}