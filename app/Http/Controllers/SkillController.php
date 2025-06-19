<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Models\Metier;
use App\Models\Metier\Skill;
use App\Models\Professional;
use App\Models\User;

use App\Repositories\MetierRepository;
use App\Repositories\Metier\SkillRepository;
use App\Repositories\ProfessionalRepository;

class SkillController extends Controller
{
    public function index(MetierRepository $metierRepository){
        $metiers = $metierRepository->getAllExcept(Metier::HALL_OWNER);
        return view('metiers.skills.index', compact('metiers'));
    }	 

    public function view($id, SkillRepository $skillRepository, ProfessionalRepository $professionalRepository){
        $skill = $skillRepository->getById($id);
        $metier = $skill->metier;
        $type = $metier->type;
        $professionals = $professionalRepository->getBySkill($skill->id);

        return view('metiers.view', compact('professionals', 'skill', 'metier', 'type'));
    }

    public function add(Request $request, SkillRepository $skillRepository, MetierRepository $metierRepository){
        $professional = Professional::getCurrent();
        $metiers = $request->input('skill');
        $skills = max($metiers);
        $metier_id = current($skills);
        $metier = $metierRepository->getById($metier_id);
        $flag = false;
        if($metier){  
            foreach ($skills as $skill => $value){
                $skill = $skillRepository->getById($skill);
                if($skill || $skill->metier_id == $metier_id){
                    $professional->skills()->attach($skill); 
                    $flag = true; 
                }           
            }
            if($flag){
                $professional->metiers()->attach($metier); 
                if($professional->status == Professional::STEP_2){
                    $professional->status = Professional::WAITING;
                }
                $professional->save(); 
                return redirect('/settings');
            }
        }
    }

    public function list($id, MetierRepository $metierRepository){
        $user = Auth::user();
        $professional = $user->getProfessional();
        if($professional->status != Professional::STEP_2){
            return redirect('/');
        }
        $metier = $metierRepository->getById($id);
        $skills = $metier->skills;
        if(count($skills) == 0){
            $professional->metiers()->attach($metier);
            if($metier->type == Metier::TYPE_PLACE){
                $professional->status = Professional::STEP_3;
            } 
            if($metier->type == Metier::TYPE_COMPANY){
                $professional->status = Professional::STEP_4;
            }
            elseif($professional->status == Professional::STEP_2){
                $professional->status = Professional::WAITING;
            }
            $professional->save(); 
            return redirect('/settings');
        }
        return view('professionals.steps.step2_1', compact('skills'));
    }

    /*public function stepList($id, MetierRepository $metierRepository){
    	$metier = $metierRepository->getById($id);
    	$types = $metier->types;
    	return view('metiers.types.ajax.steplist', compact('types'));
    }*/

}