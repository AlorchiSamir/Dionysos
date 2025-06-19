<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

use App\Models\User\Setting as User_Setting;
use App\Models\Professional\Setting as Professional_Setting;
use App\Models\Price;
use App\Models\Professional;
use App\Models\Tools\Tools;
use App\Models\Tools\Message;

use App\Repositories\User\SettingRepository as User_SettingRepository;
use App\Repositories\Professional\SettingRepository as Professional_SettingRepository;
use App\Repositories\PriceRepository;

class SettingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(SettingRequest $request, $category = null){ 
        $user = Auth::user();
        if($user->isProfessional()){
            return $this->professional($request, $category);
        }
        else{
            return $this->user($request, $user, $category);
        }      

    }

    private function user($request, $user, $category){    
        switch ($category) {            
            default:
                return $this->user_general($request, $user);
                break;
        }        
    }

    private function professional($request, $category){

        $professional = Professional::getCurrent();

        switch ($category) {
            case 'price':
                return $this->professional_price($request, $professional);
                break;
            case 'address':
                return $this->professional_address($professional);
                break;            
            default:
                return $this->professional_general($request, $professional);
                break;
        }
        
    }

    private function professional_general($request, $professional){
        if($request->isMethod('post')){
            $settingRepository = new Professional_SettingRepository(new Professional_Setting());
            $avatar = ($files = $request->file('avatar')) ? Tools::UploadImage($files, 'avatar', true) : null;
                  
            if(!is_null($avatar)){
                $datas = [
                    Professional_Setting::AVATAR => $avatar           
                ];
                $settingRepository->updateSettings($datas);
            } 
            
            $professional->description = $request->description;
            $professional->website = $request->website;
            $professional->save();            
            Message::getInstance()->add(__('success_settings'), 1);
            return redirect('/settings');
        }
        $settings = $professional->getAllSettings();
        $type = 'general';
        return view('settings.professional.index', compact('settings', 'professional', 'type'));
    }

    private function professional_price($request, $professional){
        if($request->isMethod('post')){
            $settingRepository = new Professional_SettingRepository(new Professional_Setting());
            $this->savePrice(['price' => $request->price, 'type' => $request->type, 'professional_id' => $professional->id]);
            $datas = [                
                Professional_Setting::DISTANCE => $request->distance             
            ];
            $settingRepository->updateSettings($datas);
            $messages = new Message();
            Message::getInstance()->add(__('success_settings'), 1);
            return redirect('/settings/price');
        }
        $settings = $professional->getAllSettings();
        $professional->price = $professional->getCurrentPrice($professional->id);
        $type = 'price';
        return view('settings.professional.price', compact('settings', 'professional', 'type'));
    }

    private function professional_address($professional){
        $settings = $professional->getAllSettings();
        $address = $professional->getAddress();
        $type = 'address';
        return view('settings.professional.address', compact('settings', 'professional', 'type', 'address'));
    }

    private function user_general($request, $user){

        $settingRepository = new User_SettingRepository(new User_Setting());
             
        if($request->isMethod('post')){
            
            $avatar = ($files = $request->file('avatar')) ? Tools::UploadImage($files, 'avatar', true) : null;
            
            if(!is_null($avatar)){
                $datas = [
                    Professional_Setting::AVATAR => $avatar            
                ];
                $settingRepository->updateSettings($datas);
            }
            
            Message::getInstance()->add(__('success_settings'), 1);
            return redirect('/settings');
        }       
        $settings = $user->getAllSettings();
        return view('settings.user.index', compact('settings', 'user'));
    }

    private function savePrice($datas){
        $priceRepository = new PriceRepository(new Price());
        $price = str_replace(',', '.', $datas['price']);
        if(in_array($datas['type'], Price::$types))
        $datas = [
            'price' => $price,
            'type' => $datas['type'],
            'professional_id' => $datas['professional_id']
        ];
        $priceRepository->save($datas);
    }
}
