<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Professional;
use App\Models\User;
use App\Models\Tools\Message;

use App\Repositories\ProfessionalRepository;
use App\Repositories\HallRepository;
use App\Repositories\AddressRepository;

class AddressController extends Controller
{
    public function create(AddressRequest $request, AddressRepository $addressRepository){
        
        if($request->isMethod('post')){
        	$user = Auth::user();
        	$professional = $user->getProfessional();
	        $address = $addressRepository->save([
	          'country' => 'BE',
	          'city' => $request->input('city'),
	          'postalcode' => $request->input('postalcode'),
	          'street' => $request->input('street')
	      	]);
	        $professional->address_id = $address->id;
            if($professional->status == Professional::STEP_1){
                $professional->status = Professional::STEP_2;
            }
	        $professional->save(); 
            return redirect('/settings/address');
        } 
        return view('address.edit');    
   	}

    public function update($id, AddressRequest $request, AddressRepository $addressRepository){
        $address = $addressRepository->getById($id);
        $address->city = $request->input('city');
        $address->postal_code = $request->input('postalcode');
        $address->street = $request->input('street');
        $address->save();
        Message::getInstance()->add(__('success_address'), 1);
        return redirect('/settings/address');
    }

    public function updateHall($id, AddressRequest $request, AddressRepository $addressRepository, HallRepository $hallRepository){
        $hall = $hallRepository->getByid($id);
        $address = $addressRepository->getById($hall->address->id);
        $address->city = $request->input('city');
        $address->postal_code = $request->input('postalcode');
        $address->street = $request->input('street');
        $address->save();
        Message::getInstance()->add(__('success_address'), 1);
        return redirect('hall/settings/'.$hall->id.'/'.$hall->slug.'/address');
    }
}
