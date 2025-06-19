<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Professional;
use App\Models\Hall;
use App\Models\Address;
use App\Models\Price;
use App\Models\Tools\Tools;

use App\Repositories\ProfessionalRepository;
use App\Repositories\HallRepository;
use App\Repositories\AddressRepository;
use App\Repositories\PriceRepository;

use App\Events\VisitPage;

class HallController extends Controller
{
    /*public function __construct(){
        $this->middleware('ishallowner');
    }*/

    public function index(HallRepository $hallRepository){
		$halls = $hallRepository->getAll();
        $other_halls = array();
        return view('search.halls', compact('halls', 'other_halls'));
	}	

    public function view($id, HallRepository $hallRepository){ 
        event(new VisitPage);  	
    	$hall = $hallRepository->getById($id);
    	//$settings = $professional->getAllSettings();
    	$address = $hall->address; 
        $advices = $hall->getAdvices();         
        $userAdvice = $hall->getAdviceByCurrentUser();   
        $professional = $hall->professional;  
        $object = ['type' => 'hall', 'id' => $hall->id, 'average' => $hall->getAverageScore()];    
    	return view('halls.view', compact('hall', 'object', 'professional', 'address', 'advices', 'userAdvice'));
    }  

    public function edit(Request $request, HallRepository $hallRepository){
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
                'name' => $request->name,
                'slug' => $slug,
                'description' => null,
                'address_id' => $address->id,
                'capacity' => null,
                'parking' => null
            ];
            
            $hallRepository->save($datas);

            if($professional->status == Professional::STEP_3){
                $professional->status = Professional::WAITING;
                $professional->save();
            }
            return redirect('/hall/owner-page');
        }
        return view('halls.edit');
    }

    public function gallery($id, HallRepository $hallRepository){
        $hall = $hallRepository->getById($id);
        return view('halls.images.gallery', compact('hall'));

    }

    public function ownerPage(HallRepository $hallRepository){
        $professional = Professional::getCurrent();
        $halls = $professional->halls;
        return view('halls.owner-page', compact('halls'));
    }

    public function searching(HallRepository $hallRepository){  
        $options = array();      
        if(isset($_POST['name'])){
            $options['name'] = $_POST['name'];
        }
        if(isset($_POST) && $_POST['city'] != ''){
            $options['city'] = $_POST['city']; 
        }
        $halls = $hallRepository->getByOptions($options); 
        $count = $hallRepository->getByOptions($options, true); 
        $pagination = true;     
        return view('halls.ajax.searching', compact('halls', 'count', 'pagination'));
    }

    public function settings($id, $slug, $category = null, Request $request, HallRepository $hallRepository){
        $hall = $hallRepository->getById($id);

        switch ($category) {
            case 'price':
                return $this->setting_price($request, $hall);
                break;
            case 'address':
                return $this->setting_address($hall);
                break;            
            default:
                return $this->setting_general($request, $hall);
                break;
        }
        
    }

    private function setting_general($request, $hall){
        if($request->isMethod('post')){
            $hall->name = $request->name;
            $hall->description = $request->description;
            $hall->save();         
        }
        
        $type = 'general';
        return view('settings.halls.index', compact('hall', 'type'));
    }

    private function setting_price($request, $hall){

        if($request->isMethod('post')){
            $priceRepository = new PriceRepository(new Price());
            $price = str_replace(',', '.', $request->price);
            if(in_array($request->type, Price::$types))
            $datas = [
                'price' => $price,
                'type' => $request->type,
                'hall_id' => $hall->id
            ];
            $priceRepository->save($datas);            
        }
        
        $hall->price = $hall->getCurrentPrice($hall->id); 
        $type = 'price';
        return view('settings.halls.price', compact('hall', 'type'));
    }

    private function setting_address($hall){
        $address = $hall->address;
        $type = 'address';
        return view('settings.halls.index', compact('hall', 'address', 'type'));
    }
    
}