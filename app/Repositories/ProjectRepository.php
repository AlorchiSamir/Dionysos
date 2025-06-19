<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;

class ProjectRepository implements RepositoryInterface
{

    protected $project;

	public function __construct(Project $project){
		$this->project = $project;
	}

	public function save($datas){	
					
        $this->project->user_id = $datas['user_id'];
    	$this->project->name = $datas['name'];
    	$this->project->date_event = $datas['date_event'];
    	$this->project->status = $datas['status'];
        $this->project->save();
        return $this->project;
	}

	public function getById($id){
		return $this->project->findOrFail($id);
	}

	public function getAll(){
		return $this->project->all();
	}

}