<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserFirma;
use App\Mail\InregistrareUserFirma;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/rezervari';

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
            'firma_nume' => ['required', 'string', 'max:150'],
            'firma_punct_lucru' => ['required', 'string', 'max:150'],
            'firma_cif' => ['max:100'],
            'firma_nr_orc' => ['max:100'],
            'nume' => ['required', 'string', 'max:150'],
            'telefon' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'acord_de_confidentialitate' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // protected function create(array $data)
    protected function create(array $data)
    {
        $firma = UserFirma::create([
            'nume' => $data['firma_nume'],
            'punct_lucru' => $data['firma_punct_lucru'],
            'cif' => $data['firma_cif'],
            'nr_orc' => $data['firma_nr_orc'],
            'persoana_contact' => $data['nume'],
            'telefon' => $data['telefon'],
            'email' => $data['email'],
        ]);

        $firmaId = $firma->id;

        $user = User::create([
            'user_firma_id' => $firmaId,
            'nume' => $data['nume'],
            'telefon' => $data['telefon'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        
        \Mail::to('carabus25@yahoo.com')->send(
            new InregistrareUserFirma($firma, $user)
        );

        return $user;
    }
}
