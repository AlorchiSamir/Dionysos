<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professional;
use App\Models\Company;
use App\Models\Address;
use App\Models\Metier;
use App\Models\Tools\Tools;

use App\Repositories\CompanyRepository;
use App\Repositories\AddressRepository;
use App\Repositories\MetierRepository;

use App\Events\VisitPage;

class CompanyController extends Controller{

    public function index(CompanyRepository $companyRepository, MetierRepository $metierRepository){  
        $metiers = $metierRepository->getByType(Metier::TYPE_COMPANY);     
        $companies = $companyRepository->getAllForPaginate();
        return view('companies.index', compact('companies', 'metiers'));
    }

    public function view($id, CompanyRepository $companyRepository){ 
        event(new VisitPage);      
        $company = $companyRepository->getById($id);
        //$settings = $professional->getAllSettings();
        $address = $company->address; 
        $advices = $company->getAdvices();         
        $userAdvice = $company->getAdviceByCurrentUser();   
        $professional = $company->professional;  
        $object = ['type' => 'company', 'id' => $company->id, 'average' => $company->getAverageScore()];    
        return view('companies.view', compact('company', 'object', 'professional', 'address', 'advices', 'userAdvice'));
    } 

    public function edit(Request $request, CompanyRepository $companyRepository){
        if($request->isMethod('post')){
            $professional = Professional::getCurrent();
            $addressRepository = new AddressRepository(new Address());

            $address = $addressRepository->save([
              'country' => 'BE',
              'city' => $request->input('city'),
              'postalcode' => $request->input('postalcode'),
              'street' => $request->input('street')
            ]);

            $slug = Tools::Slugify($request->name);

            $datas = [
                'professional_id' => $professional->id,
                'metier_id' => $professional->metiers[0]->id,
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'address_id' => $address->id,
                'tva_number' => $request->tva_number
            ];
            
            $companyRepository->save($datas);

            if($professional->status == Professional::STEP_4){
                $professional->status = Professional::WAITING;
                $professional->save();
            }
            return redirect('/settings');
        }
    }

    public function rangeByMetierWithAjax(CompanyRepository $companyRepository){

        $metier = $_POST['metier'];
        $city = ($_POST['city'] != '') ? $_POST['city'] : null;

        if($metier != 'empty'){            
            $companies = (is_null($city)) ? $companyRepository->getByMetier($metier) 
            : $companyRepository->getByMetierAndCity($metier, $city);
        }
        else{
            $companies = (is_null($city)) ? $companyRepository->getAllForPaginate() 
            : $companyRepository->getByCity($city);
           
        }        
        $pagination = true;
        return view('companies.ajax.by-metier', compact('companies', 'pagination'));
    }

    public function searching(CompanyRepository $companyRepository){
        
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
            $companies = $companyRepository->getBySkillsAndOptions($skills, $options);
            $count = $companyRepository->getBySkillsAndOptions($skills, $options, true);
        }
        else{
            $companies = $companyRepository->getByOptions($options);
            $count = $companyRepository->getByOptions($options, true);
        }   

          
        $pagination = true;     
        return view('companies.ajax.searching', compact('companies', 'count', 'pagination'));
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
    
}
