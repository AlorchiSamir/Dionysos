<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Professional;
use App\Models\Professional\SocialNetwork;

use App\Repositories\ProfessionalRepository;
use App\Repositories\Professional\SocialNetworkRepository;

class SocialNetworkController extends Controller
{
    public function edit(Request $request, SocialNetworkRepository $socialnetworkRepository){
        $professional = Professional::getCurrent();  
        if($request->isMethod('post')){                      
            $networks = $request->networks;

            foreach ($networks as $network => $value) {
                if($value != ''){
                    if(in_array($network, SocialNetwork::$networks)){
                        $social_network = $socialnetworkRepository->getByNetwork($network, $professional->id);
                        if(is_null($social_network)){
                            $datas = [
                                'professional_id' => $professional->id,
                                'url' => $value,
                                'network' => $network
                            ];
                            $socialnetworkRepository->save($datas);
                        }
                        else{
                            $social_network->url = $value;
                            $social_network->save();
                        }                        
                    }
                }                
            }            
            return redirect('/settings/networks');
        }
        $type = 'network';
        $social_networks = $professional->getSocialNetworksInArray();
        return view('professionals.social_networks.edit', compact('type', 'social_networks'));
    }
       
}