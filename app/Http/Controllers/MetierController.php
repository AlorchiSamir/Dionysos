<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Metier;

use App\Repositories\MetierRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\HallRepository;

class MetierController extends Controller
{

    public function index(MetierRepository $metierRepository, ProfessionalRepository $professionalRepository, 
                          HallRepository $hallRepository){       
        $metiers['person']['metiers'] = $metierRepository->getByType(Metier::TYPE_PERSON);
        $metiers['person']['count'] = $professionalRepository->getCountByType(Metier::TYPE_PERSON);
        $metiers['company']['metiers'] = $metierRepository->getByType(Metier::TYPE_COMPANY);
        $metiers['company']['count'] = $professionalRepository->getCountByType(Metier::TYPE_COMPANY);
        $metiers['hall']['count'] = $hallRepository->getCount();
        return view('metiers.index', compact('metiers'));
    }

    public function view($id, MetierRepository $metierRepository, ProfessionalRepository $professionalRepository){
        $metiers = $metierRepository->getByType(Metier::TYPE_PERSON);
        $metier = $metierRepository->getById($id);
        $options['metier'] = $metier->id;
        $type = $metier->type;
        $professionals = $professionalRepository->getByOptions($options);
        $count = $professionalRepository->getByOptions($options, true);
        return view('metiers.view', compact('professionals', 'metier', 'metiers', 'type', 'count'));
    }

    public function stepList(MetierRepository $metierRepository){
    	$metiers = $metierRepository->getAll();
    	return view('metiers.ajax.steplist', compact('metiers'));
    }

    /*public function hallOwner(MetierRepository $metierRepository){
    	$professional = Professional::getCurrent();
    	if($professional->status == Professional::STEP_2){	    	
	        $metier = $metierRepository->getByName(Metier::HALL_OWNER);
	    	$professional->metiers()->attach($metier);     	
            $professional->status = Professional::STEP_3;
            $professional->save();
            return redirect('/step/3');
        }
        else{
        	return redirect('/');
        }
    }*/

    public function getOptions(MetierRepository $metierRepository){
        $metier = $metierRepository->getById($_POST['metier']);
        $type = $metier->type;
        return view('metiers.options', compact('metier', 'type'));
    }
}
