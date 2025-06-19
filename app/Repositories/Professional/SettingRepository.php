<?php

namespace App\Repositories\Professional;

use Illuminate\Support\Facades\Auth;

use App\Repositories\RepositoryInterface;

use App\Models\Professional\Setting as Professional_Setting;

class SettingRepository implements RepositoryInterface
{

  protected $setting;
  protected $professional_id;

	public function __construct(Professional_Setting $setting){
		$this->setting = $setting;
    $user = Auth::user();
    if($user && $professional = $user->getProfessional()){      
      $this->professional_id = $professional->id;
    }    
	}

	public function save($datas){
    	$this->setting->professional_id = $datas['professional_id'];
    	$this->setting->setting = $datas['setting'];
    	$this->setting->value = $datas['value'];
    	$this->setting->save();
	}

	public function delete($id){
		return $this->setting->destroy($id);
	}

	public function getById($id){
		return $this->setting->findOrFail($id);
	}

	public function getByUser(){
		$user_id = Auth::id();
		return $this->setting->where('professional_id', '=', $professional_id)->get();
	}

	public function getBySetting($setting, $professional_id = null){
		if($professional_id == null){
			$professional_id = $this->professional_id;
		}
		return $this->setting->where('professional_id', '=', $professional_id)->where('setting', '=', $setting)->first();
	}

	public function updateSettings($datas){
    
    foreach ($datas as $key => $data){
      if(in_array($key, Professional_Setting::$settings)){
        $setting = Professional_Setting::where([['professional_id', '=', $this->professional_id], ['setting', '=', $key]])->first();
        if(is_null($setting)){
          $set_datas = [
            'setting' => $key,
            'professional_id' => $this->professional_id,
            'value' => $data
          ];
          Professional_Setting::insert($set_datas);
        }        
        elseif($setting->value != $data){
            $setting->value = $data;
            $setting->update();          
        }        
      }
    }
  }

}