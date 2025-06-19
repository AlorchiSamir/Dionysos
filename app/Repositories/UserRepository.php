<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\User\Setting as User_Setting;
use App\Models\User\Avatar as User_Avatar;
use App\Repositories\User\AvatarRepository;
use App\Repositories\User\SettingRepository;

class UserRepository implements RepositoryInterface
{

    protected $user;

	public function __construct(User $user){
		$this->user = $user;
	}

	public function save($datas)
	{
		return User::create($datas);
	}

	public function getById($id){
		return $this->user->findOrFail($id);
	}

	public function getAvatar($user_id){
		$settingRepository = new SettingRepository(new User_Setting());
		$avatarRepository = new AvatarRepository(new User_Avatar());
		$setting = $settingRepository->getBySetting(User_Setting::AVATAR, $user_id);
		if($setting == null){
			return null;
		}
		return $avatarRepository->getById($setting->value);
	}

	public function getSettings(){
		$avatarRepository = new AvatarRepository(new User_Avatar());
		$setting = new User_Setting();
		$user_id = Auth::id();
		$settings = $setting->where('user_id', '=', $user_id)->get();
		$array = array();
		foreach ($settings as $setting){
			$array[$setting->setting] = $setting->value;
		}		
		if(isset($array['avatar'])){			
			$avatar = $avatarRepository->getById($array['avatar']);
			$array['avatar'] = $avatar->path;
			$array['avatar_count'] = $avatarRepository->getCountByUser();
		}
		else{
			$array['avatar_count'] = $avatarRepository->getCountByUser() + 1;
		}
		return $array;
	}

}