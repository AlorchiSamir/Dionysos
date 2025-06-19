<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User\Interaction;
use App\Models\Metier;

use Illuminate\Http\Request;

use App\Repositories\User\InteractionRepository;
use App\Repositories\MetierRepository;

class InteractionController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($type, InteractionRepository $interactionRepository, MetierRepository $metierRespository){
        if(in_array($type, Interaction::$types)){
            $category = (isset($_GET['cat'])) ? $_GET['cat'] : 'professional';
            $_professionals = array();
            $halls = array();
            $_companies = array();
            $metiers = array();
            $types = array();
            if(count($interactions_pro = $interactionRepository->getByObject($type, Interaction::OBJECT_PROFESSIONAL))){
                array_push($types, 'professional');
            }
            if(count($interactions_company = $interactionRepository->getByObject($type, Interaction::OBJECT_COMPANY))){
                array_push($types, 'company');
            }
            if(count($interactions_hall = $interactionRepository->getByObject($type, Interaction::OBJECT_HALL))){
                array_push($types, 'hall');
            }
            switch ($category) {
                case 'professional':
                    
                    foreach ($interactions_pro as $interaction){
                        $professional = $interaction->getObject();
                        $metier_id = $professional->metiers[0]->id;
                        if(!isset($_professionals[$metier_id])){
                            $_professionals[$metier_id] = array();
                        }           
                        array_push($_professionals[$metier_id], $professional);
                        $metiers[$metier_id] = $professional->metiers[0];
                    }
                    return view('users.interactions.index', compact('_professionals', 'metiers', 'types', 'category', 'type'));
                    break;
                case 'company':
                    
                    foreach ($interactions_company as $interaction){                        
                        $company = $interaction->getObject();                       
                        $metier_id = $company->metier_id;
                        if(!isset($_professionals[$metier_id])){
                            $_companies[$metier_id] = array();
                        }         
                        array_push($_companies[$metier_id], $company);
                        $metiers[$metier_id] = $company->metier; 
                    }
                    return view('users.interactions.index', compact('metiers', '_companies', 'types', 'category','type'));
                    break;
                case 'hall':
                    
                    foreach ($interactions_hall as $interaction){
                        $hall = $interaction->getObject(); 
                        array_push($halls, $hall);
                    }
                    return view('users.interactions.index', compact('halls', 'types', 'category', 'type'));
                    break;

            }
        }   
        else{
            return redirect('/');
        }
    }

    public function rangeByMetier(InteractionRepository $interactionRepository, MetierRepository $metierRespository){

        $metier = $metierRespository->getById($_POST['metier']);
        $object_type = ($metier->type == Metier::TYPE_PERSON) ? Interaction::OBJECT_PROFESSIONAL : $metier->type;
        $interactions = $interactionRepository->getByObject('interest', $object_type);
        $metiers = array();
        if($object_type == Interaction::OBJECT_PROFESSIONAL){

            $professionals = array();
            foreach ($interactions as $interaction){
                $professional = $interaction->getObject();
                $metier_id = $professional->metiers[0]->id;
                if($metier_id == $_POST['metier']){
                    array_push($professionals, $professional);   
                }    
            }
            return view('professionals.list', compact('professionals'));
        }
        elseif($object_type == Interaction::OBJECT_COMPANY){
            $companies = array();
            foreach ($interactions as $interaction){
                $company = $interaction->getObject();
                $metier_id = $company->metier_id;
                if($metier_id == $_POST['metier']){
                    array_push($companies, $company);   
                }    
            }
            return view('companies.list', compact('companies'));
        }
    }

    public function allMetier(InteractionRepository $interactionRepository){
        $metier_type = $_POST['metier'];
        $interactions = $interactionRepository->getByObject(Interaction::TYPE_INTEREST, $metier_type);
        $metiers = array();
        if($metier_type == Interaction::OBJECT_PROFESSIONAL){
            $_professionals = array();
            foreach ($interactions as $interaction){
                $professional = $interaction->getObject();
                $metier_id = $professional->metiers[0]->id;
                if(!isset($_professionals[$metier_id])){
                    $_professionals[$metier_id] = array();
                }           
                array_push($_professionals[$metier_id], $professional);
                $metiers[$metier_id] = $professional->metiers[0];
            }
            return view('users.interactions.list', compact('_professionals', 'metiers'));
        }
        elseif($metier_type == Interaction::OBJECT_COMPANY){
            $_companies = array();
            foreach ($interactions_company as $interaction){
                $company = $interaction->getObject(); 
                $metier_id = $company->metier_id;
                if(!isset($_professionals[$metier_id])){
                    $_companies[$metier_id] = array();
                }           
                array_push($_companies[$metier_id], $company);
                $metiers[$metier_id] = $company->metier;           
            }
            return view('users.interactions.list', compact('_companies', 'metiers'));
        }
    }

    public function interaction(){
        $object_id = $_POST['object_id'];
        $object_type = $_POST['object_type'];
        $type = $_POST['type'];
        $value = (isset($_POST['value'])) ? $_POST['value'] : null;
        $user_id = Auth::user()->id;
        switch ($type) {
            case 'like':
                $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $object_id], ['object_type', '=', $object_type], ['type', '=', Interaction::TYPE_LIKE], ['value', '=', 0]])->first();
                if(is_null($interaction)){
                    $datas = [
                        'type' => Interaction::TYPE_LIKE,
                        'user_id' => $user_id,
                        'object_id' => $object_id,
                        'object_type' => $object_type
                    ];
                    Interaction::insert($datas);
                }   
                else{
                    $interaction->value = 1;
                    $interaction->update();
                }             
                break;
            case 'dislike':
                $interaction = $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $object_id], ['object_type', '=', $object_type], ['type', '=', Interaction::TYPE_LIKE], ['value', '=', 1]])->first();
                $interaction->value = 0;
                $interaction->update();
                break;
            case 'interest':
                $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $object_id], ['object_type', '=', $object_type], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 0]])->first();
                if(is_null($interaction)){
                    $datas = [
                        'type' => Interaction::TYPE_INTEREST,
                        'user_id' => $user_id,                        
                        'object_id' => $object_id,
                        'object_type' => $object_type
                    ];
                    Interaction::insert($datas);
                } 
                else{
                    $interaction->value = 1;
                    $interaction->update();
                }               
                break;
            case 'disinterest':
                $interaction = $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $object_id], ['object_type', '=', $object_type], ['type', '=', Interaction::TYPE_INTEREST], ['value', '=', 1]])->first();
                $interaction->value = 0;
                $interaction->update();
                break;
            case 'vote':
                $interaction = Interaction::where([['user_id', '=', $user_id], ['object_id', '=', $object_id], ['object_type', '=', $object_type], ['type', '=', Interaction::TYPE_VOTE]])->first();
                if(is_null($interaction)){
                    $datas = [
                            'type' => Interaction::TYPE_VOTE,
                            'user_id' => $user_id,                        
                            'object_id' => $object_id,
                            'object_type' => $object_type,
                            'value' => $value
                        ];
                    Interaction::insert($datas);
                }
                else{
                    if($interaction->value == 0){
                        $interaction->value = $value;
                    }
                    else{
                        $interaction->value = ($interaction->value == $value) ? 0 : 0 - $interaction->value;
                    }
                    
                    $interaction->update();
                }
                break;
        }
        
    }
}
