<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Hall;
use App\Models\Company;

use App\Models\Metier;
use App\Models\Address;
use App\Models\User\Setting as User_Setting;

use Illuminate\Http\Request;

use App\Repositories\ProfessionalRepository;
use App\Repositories\HallRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\MetierRepository;
use App\Repositories\User\SettingRepository;

class SearchController extends Controller
{
    public function index(Request $request, ProfessionalRepository $professionalRepository, HallRepository $hallRepository, 
                          CompanyRepository $companyRepository, MetierRepository $metierRepository){  
        $options = array();

        $skills = (isset($_GET['skills'])) ? $_GET['skills'] : 'empty';

        if(isset($_GET['city'])){
            $query = $_GET['city'];
            $split = explode(',', $query);
            $city = $split[0];
            $_SESSION['city'] = $city;
            $cities = Address::getCitiesAround($city);
            $options['city'] = $city;
        }
        else{
            $city = null;
            $cities = null;
        }
        
        $metier = $_GET['metier'];
        if($metier == 'empty'){
            $metier = null;
            $path = $request->route()->action['as'];
            $parts = explode('.', $path);
            $type = $parts[0];
        }
        else{
            if(is_numeric($metier)){
                $metier = $metierRepository->getById($metier);
            }
            else{
                $metier = $metierRepository->getByName($metier);
            }
            $metier_name = $metier->name;
            $_SESSION['metier'] = $metier_name;
            $options['metier'] = $metier->id;
            $type = $metier->type;
        }

       if(isset($_GET['name'])){
            $name = $_GET['name'];
            $options['name'] = $name;
        }
        else{
            $name = null;
        }

        if($type == Metier::TYPE_PERSON){ 

            if($skills != 'empty'){            
                $professionals = $professionalRepository->getBySkillsAndOptions($skills, $options);
                $count = $professionalRepository->getBySkillsAndOptions($skills, $options, true);
            }
            else{
                $professionals = $professionalRepository->getByOptions($options);
                $count = $professionalRepository->getByOptions($options, true);
            } 
            if(is_null($city)){
                $other_professionals = array();
            }
            else{
                $other_professionals = $professionalRepository->getByMetierAndCities($metier->id, $cities);
            }   

            $metiers = $metierRepository->getByType($type);     
            
            if(count($professionals) > 0 || count($other_professionals) > 0){
                return view('search.professionals', compact('professionals', 'other_professionals', 'count', 'metier', 'city', 'type', 'skills', 'metiers'));
            }           
        }
        if($type == Metier::TYPE_COMPANY){

            if($skills != 'empty'){            
                $companies = $companyRepository->getBySkillsAndOptions($skills, $options);
                $count = $companyRepository->getBySkillsAndOptions($skills, $options, true);
            }
            else{
                $companies = $companyRepository->getByOptions($options);
                $count = $companyRepository->getByOptions($options, true);
            }
            
            if(is_null($city)){
                $other_companies = array();
            }
            else{
                $other_companies = $companyRepository->getByMetierAndCities($metier->id, $cities);
            }
            if(count($companies) > 0 || count($other_companies) > 0){
                return view('search.companies', compact('companies', 'other_companies', 'count', 'metier', 'city', 'type', 'skills'));
            }           
        }
        if($type == Metier::TYPE_PLACE){
            $halls = $hallRepository->getByOptions($options);
            $count = $hallRepository->getByOptions($options, true);
            $other_halls = (isset($city) && !is_null($city)) ? $hallRepository->getByCities($cities) : array();
            if(count($halls) > 0 || count($other_halls) > 0){
                return view('search.halls', compact('halls', 'other_halls', 'count', 'metier', 'city', 'type'));
            }           
        }
        return view('search.no-result');
        
    }

    public function register(MetierRepository $metierRepository, SettingRepository $settingRepository){
        $query = '';
        $first = true;
        $skills = (isset($_POST['skills'])) ? $_POST['skills'] : 'empty';
        if($skills != 'empty'){
            $query .= ($first) ? '?' : '&';
            foreach ($skills as $skill) {
                $query .= 'skills[]='.$skill.'&';
            }
            $query = substr($query,0,-1);
            $first = false;
        }
        if(isset($_POST['metier']) && $_POST['metier'] != 'empty'){
            $metier = $metierRepository->getById($_POST['metier']);
            $query .= ($first) ? '?' : '&';
            $query .= 'metier='.$metier->name;
            $first = false;
        }
        if(isset($_POST['name']) && $_POST['name'] != ''){
            $query .= ($first) ? '?' : '&';
            $query .= 'name='.$_POST['name'];
            $first = false;
        }
        if(isset($_POST) && $_POST['city'] != ''){
            $query .= ($first) ? '?' : '&';
            $query .= 'city='.$_POST['city'];
            $first = false;
        }
        $datas = [
            User_Setting::SEARCH => $query            
        ];
        $settingRepository->updateSettings($datas);
    }
       
}