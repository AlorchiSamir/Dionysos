<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Models\Advice;

class AdviceRepository implements RepositoryInterface
{

    protected $advice;

	public function __construct(Advice $advice){
		$this->advice = $advice;
	}

	public function save($datas){						
        $this->advice->user_id = $datas['user_id'];
    	$this->advice->object_id = $datas['object_id'];
    	$this->advice->type = $datas['type'];
    	$this->advice->comment = $datas['comment'];
    	$this->advice->score = $datas['score'];
    	$this->advice->status = Advice::POSTED;
        $this->advice->save();
        return $this->advice;
	}

	public function getById($id){
		return $this->advice->findOrFail($id);
	}

	public function getAll(){
		return $this->advice->all();
	}

	public function getByObjectAndType($object_id, $type){
		return $this->advice->where('object_id', '=', $object_id)->where('type', '=', $type)->get();
	}

	public function getByStatus($status){
		if(in_array($status, Advice::$status)){
			return $this->advice->where('status', '=', $status)->get();
		}
		else{
			return null;
		}
	}

	public function getSumOfScore($object_id, $type){
		return $this->advice->where('object_id', '=', $object_id)->where('type', '=', $type)->sum('score');
	}

	public function getByUser($user_id = null){
		if(is_null($user_id)){
			$user_id = Auth::id();
		}
		return $this->advice->where('user_id', '=', $user_id)->get();
	}

	public function getByObjectAndCurrentUser($object_id, $type){
		$user_id = Auth::id();
		return $this->advice->where('object_id', '=', $object_id)->where('user_id', '=', $user_id)->where('type', '=', $type)->first();
	}

}