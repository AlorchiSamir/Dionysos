<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Professional;
use App\Models\Metier;
use App\Models\Advice;
use App\Models\Metier\Skill;
use App\Models\User;
use App\Models\Address;

use App\Repositories\ProfessionalRepository;
use App\Repositories\MetierRepository;
use App\Repositories\AdviceRepository;

use App\Events\VisitPage;

class ProfessionalController extends Controller
{
    public function index(ProfessionalRepository $professionalRepository, MetierRepository $metierRepository){
        $metiers = $metierRepository->getByType(Metier::TYPE_PERSON);
		$professionals = $professionalRepository->getAllByType(Metier::TYPE_PERSON);
        $pagination = true;    
        $type = Metier::TYPE_PERSON;
        $options = array();
        $count = $professionalRepository->getByOptions($options, true);
        return view('search.professionals', compact('professionals', 'metiers', 'type', 'count'));
    	
	}	

    public function view($id, ProfessionalRepository $professionalRepository){ 
        event(new VisitPage);       
        $adviceRepository = new AdviceRepository(new Advice());   	
    	$professional = $professionalRepository->getById($id);
        if($professional->metiers[0]->type != Metier::TYPE_PERSON){
            return redirect('/');
        }
    	$settings = $professional->getAllSettings();
    	$address = $professional->getAddress(); 

        $advices = $professional->getAdvices();         
        $userAdvice = $professional->getAdviceByCurrentUser();  
        $networks = $professional->getSocialNetworksInArray();
        $object = ['type' => 'professional', 'id' => $professional->id, 'average' => $professional->getAverageScore()];   

    	return view('professionals.view', compact('professional', 'object', 'settings', 'address', 'advices', 'userAdvice', 'networks'));
    }  

    public function step($n){
        $datas = null;
        if($n == 2){
            $metierRepository = new MetierRepository(new Metier());
            $datas = $metierRepository->getInArrayByType();
        }        
        return view('professionals.steps.step'.$n, compact('datas'));
    }
    
    public function rangeBySkills(ProfessionalRepository $professionalRepository, MetierRepository $metierRepository){
       
        $skills = $_GET['skills'];
        $metier = $_GET['metier'];
        $city = ($_GET['city'] != '') ? $_GET['city'] : null;
        $cities = Address::getCitiesAround($city);
        if($skills != 'empty'){            
            $professionals = (is_null($city)) ? $professionalRepository->getBySkills($skills) 
            : $professionalRepository->getBySkillsAndCity($skills, $city);
            $other_professionals = $professionalRepository->getBySkillsAndCities($skills, $cities);
        }
        else{
            $professionals = (is_null($city)) ? $professionalRepository->getByMetier($metier) 
            : $professionalRepository->getByMetierAndCity($metier, $city);
            $other_professionals = $professionalRepository->getByMetierAndCities($metier, $cities);
        }        
        $metier = $metierRepository->getById($metier);
        return view('search.professionals', compact('professionals', 'metier', 'city', 'skills', 'other_professionals'));
    }

    public function searching(ProfessionalRepository $professionalRepository){
        
        $options = array();
        $skills = (isset($_POST['skills'])) ? $_POST['skills'] : 'empty';
        if(isset($_POST['metier']) && $_POST['metier'] != 'empty'){
            $options['metier'] = $_POST['metier'];
        }
        if(isset($_POST['name'])){
            $options['name'] = $_POST['name'];
        }
        if(isset($_POST) && $_POST['city'] != ''){
            $options['city'] = $_POST['city'];
        }

        if($skills != 'empty'){            
            $professionals = $professionalRepository->getBySkillsAndOptions($skills, $options);
            $count = $professionalRepository->getBySkillsAndOptions($skills, $options, true);
        }
        else{
            $professionals = $professionalRepository->getByOptions($options);
            $count = $professionalRepository->getByOptions($options, true);
        } 

        $pagination = true;     
        return view('professionals.ajax.searching', compact('professionals', 'count', 'pagination'));
    }

    public function rangeBySkillsAndCitiesWithAjax(ProfessionalRepository $professionalRepository){
        
        $skills = $_POST['skills'];
        $metier = $_POST['metier'];
        $city = ($_POST['city'] != '') ? $_POST['city'] : null;
        $cities = Address::getCitiesAround($city);

        if($skills != 'empty'){            
            $professionals = $professionalRepository->getBySkillsAndCities($skills, $cities);
        }
        else{
            $professionals = $professionalRepository->getByMetierAndCities($metier, $cities);
        }        
        $pagination = false;
        return view('professionals.ajax.by-skills', compact('professionals', 'pagination'));
    }

    public function rangeByMetier(ProfessionalRepository $professionalRepository, MetierRepository $metierRepository){
        $metier = $_GET['metier'];
        $city = (isset($_GET['city']) && $_GET['city'] != '') ? $_GET['city'] : null;

        if($metier != 'empty'){            
            $professionals = (is_null($city)) ? $professionalRepository->getByMetier($metier) 
            : $professionalRepository->getByMetierAndCity($metier, $city);
        }
        else{
            $professionals = (is_null($city)) ? $professionalRepository->getAllByType(Metier::TYPE_PERSON) 
            : $professionalRepository->getByCity($city);
        }       
        $metiers = $metierRepository->getByType(Metier::TYPE_PERSON);
        $pagination = true;
        return view('professionals.index', compact('professionals', 'metiers', 'city', 'pagination'));
    }    

    public function rangeByMetierAndCitiesWithAjax(ProfessionalRepository $professionalRepository){
        $metier = $_POST['metier'];
        $city = ($_POST['city'] != '') ? $_POST['city'] : null;
        $cities = Address::getCitiesAround($city);

        if($metier != 'empty'){            
            $professionals = (is_null($city)) ? $professionalRepository->getByMetier($metier) 
            : $professionalRepository->getByMetierAndCity($metier, $city);
        }
        else{
            $professionals = (is_null($city)) ? $professionalRepository->getAllByType(Metier::TYPE_PERSON) 
            : $professionalRepository->getByCity($metier, $city);
        }        
        return view('professionals.ajax.by-metier', compact('professionals'));
    }

}
