<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\Auth;

use App\Repositories\RepositoryInterface;

use App\Models\User\Interaction;

class InteractionRepository implements RepositoryInterface
{

  protected $interaction;
  protected $user;

	public function __construct(Interaction $interaction){
		$this->interaction = $interaction;
    $user = Auth::user(); 
    $this->user_id = ($user) ? $user->id : null;        
	}

	public function save($datas){
    	$this->interaction->user_id = $datas['user_id'];
    	$this->interaction->setting = $datas['setting'];
    	$this->interaction->value = $datas['value'];
    	$this->interaction->save();
	}

	public function delete($id){
		return $this->interaction->destroy($id);
	}

	public function getById($id){
		return $this->interaction->findOrFail($id);
	}

	public function getByCurrentUser(){
		return $this->interaction->where('user_id', '=', $this->user_id)->get();
	}

	public function getByObject($type, $object_type){
    return $this->interaction->where('user_id', '=', $this->user_id)->where('type', '=', $type)
                             ->where('object_type', '=', $object_type)->get();
  }
}