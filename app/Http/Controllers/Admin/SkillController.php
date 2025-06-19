<?php

namespace App\Http\Controllers\Admin;

use App\Models\Metier\Skill;
use App\Models\Tools\Tools;

use App\Repositories\Metier\SkillRepository;
use App\Repositories\MetierRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{    
    public function index($id, SkillRepository $skillRepository, MetierRepository $metierRepository){
        $metier = $metierRepository->getById($id);
        $skills = $skillRepository->getByMetier($id);
    	return view('admin.metiers.skills.index', compact('skills', 'metier'));
    }

    public function create($id, Request $request){
        $slug = Tools::Slugify($request->name);
        if($request->isMethod('post')){
            $datas = [
                'name' => $request->name,
                'color' =>$request->color,
                'metier_id' => $id,
                //'slug' => $slug
            ];
            $skillRepository = new SkillRepository(new skill());
            $skillRepository->save($datas);
            return redirect('admin/metier/skill/'.$id);
        }
    	return view('admin.metiers.skills.edit', compact('id'));
    }

    public function update($id, Request $request){
        $skillRepository = new SkillRepository(new skill());
        $skill = $skillRepository->getById($id);
        if($request->isMethod('post')){
            $skill->name = $request->name;
            $skill->color = $request->color;          
            $skill->update();
            return redirect('admin/metier/skill/'.$skill->metier_id);
        }
    	return view('admin.metiers.skills.edit', compact('skill'));
    }
}
