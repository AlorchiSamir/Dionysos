<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Professional;
use App\Models\Address;
use App\Models\Email;
use App\Models\Tools\Tools;

use App\Repositories\UserRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\AddressRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tel' => ['min: 10', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {       
        $this->redirectTo = '/'; 
        $type = $data['type'];
        $userRepository = new UserRepository(new User());
        $addressRepository = new AddressRepository(new Address());
        $user = $userRepository->save([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'type' => strtoupper($type),
            'password' => bcrypt($data['password']),
        ]);  
        if($type == 'pro'){
            $this->redirectTo = '/address/create';
            $professionalRepository =  new ProfessionalRepository(new Professional());
            $professional = $professionalRepository->save(['user' => $user]);
        }         
        Email::insert($user, Email::VALIDITY);
        return $user;
    }
}
