<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Models\Email;

class EmailRepository implements RepositoryInterface
{

    protected $email;

	public function __construct(Email $email){
		$this->email = $email;
	}

	public function save($datas){	
					
        $this->email->recipient_id = $datas['recipient']->id;
        $this->email->mail = $datas['recipient']->email;
    	$this->email->type = $datas['type'];
        $this->email->save();
        return $this->email;
	}

	public function getById($id){
		return $this->email->findOrFail($id);
	}

	public function getAll(){
		return $this->email->all();
	}

	

}