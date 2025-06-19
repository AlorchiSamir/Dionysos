<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\Auth;

use App\Repositories\RepositoryInterface;

use App\Models\User\Setting as Setting;

class SettingRepository implements RepositoryInterface
{

  protected $setting;
  protected $user_id;

	public function __construct(Setting $setting){
		$this->setting = $setting;
    $user = Auth::user(); 
    $this->user_id = ($user) ? $user->id : null;        
	}

	public function save($datas){
    	$this->setting->user_id = $datas['user_id'];
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
		return $this->setting->where('user_id', '=', $this->user_id)->get();
	}

	public function getBySetting($setting, $user_id = null){
		if($user_id == null){
			$user_id = $this->user_id;
		}
		return $this->setting->where('user_id', '=', $user_id)->where('setting', '=', $setting)->first();
	}

	public function updateSettings($datas){
    
    foreach ($datas as $key => $data){
      if(in_array($key, Setting::$settings)){
        $setting = Setting::where([['user_id', '=', $this->user_id], ['setting', '=', $key]])->first();
        if(is_null($setting)){
          $set_datas = [
            'setting' => $key,
            'user_id' => $this->user_id,
            'value' => $data
          ];
          Setting::insert($set_datas);
        }        
        elseif($setting->value != $data){
            $setting->value = $data;
            $setting->update();          
        }        
      }
    }
  }

}