<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // public function redirectTo() {
    //     $role = Auth::user()->role; 
    //     switch ($role) {
    //       case 'admin':
    //         return '/admin/dashboard';
    //         break;
    //       case 'seller':
    //         return '/seller/dashboard';
    //         break; 
            
    //       default:
    //         return '/home'; 
    //       break;
    //     }
    // }

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
        if( $data['role'] == 'buyer') {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'role' => ['required', 'string'],

                'username' => ['required', 'string','unique:buyers,username'],
                'fullname' => ['required', 'string'],
                'phonenumber' => ['required', 'numeric', 'min:8'],
                'gender' => ['required', 'string'],
                'country' => ['required', 'string'],
                'city' => ['required', 'string'],
                'address' => ['required', 'string', 'max:255'],
                'zipcode' => ['required', 'numeric'],
            ]);
        }
        elseif ( $data['role'] == 'seller') {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'role' => ['required', 'string'],

                'username' => ['required', 'string','unique:sellers,username'],
                'fullname' => ['required', 'string'],
                'phonenumber' => ['required', 'numeric', 'min:11'],
                'gender' => ['required', 'string'],
                'country' => ['required', 'string'],
                'city' => ['required', 'string'],
                'address' => ['required', 'string', 'max:255'],
                'zipcode' => ['required', 'numeric'],
            ]);
        }
        elseif ( $data['role'] == 'admin') {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'role' => ['required', 'string'],

                'username' => ['required', 'string','unique:admins,username'],
                'fullname' => ['required', 'string'],
                'phonenumber' => ['required', 'numeric', 'min:11'],
                'gender' => ['required', 'string'],
                'country' => ['required', 'string'],
                'city' => ['required', 'string'],
                'address' => ['required', 'string', 'max:255'],
                'zipcode' => ['required', 'numeric'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        $userid = $user->id;
            
        if( $data['role'] == 'buyer' ){
            $this->createBuyerProfile($data, $userid);
        }
        elseif( $data['role'] == 'seller' ){
            $this->createSellerProfile($data, $userid);
        }
        elseif( $data['role'] == 'admin' ){
            $this->createAdminProfile($data, $userid);
        }
        

        return $user;
    }

    protected function createBuyerProfile(array $data, $userid)
    {

        $buyer = Buyer::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'phonenumber' => $data['phonenumber'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'city' => $data['city'],
            'address' => $data['address'],
            'zipcode' => $data['zipcode'],
            'user_id' => $userid,
        ]);

        return $buyer;
    }

    protected function createSellerProfile(array $data, $userid){
        
        $seller = Seller::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'phonenumber' => $data['phonenumber'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'city' => $data['city'],
            'address' => $data['address'],
            'zipcode' => $data['zipcode'],
            'user_id' => $userid,
        ]);

        return $seller;

    }

    protected function createAdminProfile(array $data, $userid){
        
        $admin = Admin::create([
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'phonenumber' => $data['phonenumber'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'city' => $data['city'],
            'address' => $data['address'],
            'zipcode' => $data['zipcode'],
            'user_id' => $userid,
        ]);

        return $admin;

    }

    protected function check(Request $request)
    {
        request()->validate([
            'user.email' => ['required', 'string', 'email:rfc,dns', 'max:255','unique:users,email'],
            'user.password' => ['required', 'string', 'min:8'],
        ],
        [
            'unique' => 'The email has already been taken.'
        ]);
    }

}
