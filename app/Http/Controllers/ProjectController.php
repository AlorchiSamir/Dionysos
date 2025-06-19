<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;
use App\Models\User;
use App\Models\Professional;

use App\Repositories\ProjectRepository;
use App\Repositories\ProfessionalRepository;


class ProjectController extends Controller
{
    public function index(ProjectRepository $projectRepository){
    	$user = Auth::user();
		$projects = $user->projects;
    	return view('projects.index', compact('projects'));
	}	

	public function edit(Request $request, ProjectRepository $projectRepository){
		if($request->isMethod('post')){

            $user = Auth::user();           
            $datas = [
                'user_id' => $user->id,
                'name' => $request->input('name'),
                'date_event' => now(),
                'status' => 1
            ];            
            $projectRepository->save($datas);            
            return redirect('/project');
        }
        return view('projects.edit');
	}
       
}