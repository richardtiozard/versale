<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Buyer;
use App\Models\Order;
use App\Models\User;
use Auth;

class AdminController extends Controller
{
    public function index(){
        $userprofile = Admin::find(Auth::user()->admin->id);
        return view('auth.profile', [ 'userprofile' => $userprofile]);
    }

    public function update(Request $request){

        $this->validate($request, [
            'userprofile.fullname' => 'required|string',
            'userprofile.phonenumber' => 'required|numeric|min:8',
            'userprofile.country' => 'required|string',
            'userprofile.city' => 'required|string',
            'userprofile.address' => 'required|string',
            'userprofile.zipcode' => 'required|numeric',
        ]);

        $userprofile = Admin::find(Auth::user()->admin->id);
        $userprofile->fullname = $request->userprofile['fullname'];
        $userprofile->phonenumber = $request->userprofile['phonenumber'];
        $userprofile->country = $request->userprofile['country'];
        $userprofile->city = $request->userprofile['city'];
        $userprofile->address = $request->userprofile['address'];
        $userprofile->zipcode = $request->userprofile['zipcode'];
        $userprofile->save();

        return view('auth.profile', [ 'userprofile' => $userprofile]);
    }

    protected function uploadImage(Request $request){
        if($request->file()) {
            $request->validate([
                'image' => 'mimes:jpg,jpeg,png|max:2048'
            ]);

            $file_name = Auth::user()->admin->username.'.'.$request->file('image')->extension();
            $file_path = $request->file('image')->storeAs('img/user', $file_name, 'public');

            $userprofile = Admin::where('username', Auth::user()->admin->username)->first();
            echo $request->username;
            $userprofile->image = "/storage/".$file_path;
            $userprofile->save();
            
            return $file_path;
        }
    }

    public function overview(){

        $total_admin = DB::table('admins')
                        ->select(DB::raw('count(admins.id) as total_admin'))
                        ->get();
        $total_seller = DB::table('sellers')
                        ->select(DB::raw('count(sellers.id) as total_seller'))
                        ->get();
        $total_buyer = DB::table('buyers')
                        ->select(DB::raw('count(buyers.id) as total_buyer'))
                        ->get();

        $total_order = DB::table('orders')
                        ->select(DB::raw('count(orders.id) as total_order'))
                        ->where('orders.status', 'Completed')
                        ->get();
        $total_feedback = DB::table('feedback')
                        ->select(DB::raw('count(feedback.id) as total_feedback'))
                        ->where('feedback.status', 'Pending')
                        ->get();

        $data = [
            'total_admin' => $total_admin,
            'total_seller' => $total_seller,
            'total_buyer' => $total_buyer,
            'total_order' => $total_order,
            'total_feedback' => $total_feedback,
        ];

        return view('admin.overview', ['data' => $data]);
    }

    public function userIndex(){
        $roles = DB::table('users')
                    ->select(DB::raw('distinct(users.role) as role'))
                    ->get();
        $status = DB::table('users')
                    ->select(DB::raw('distinct(users.status) as status'))
                    ->get();

        $admins = DB::table('users')
                    ->select(
                        'admins.id as id' , 'admins.fullname as fullname' , 'admins.username as username' , 'admins.image as image' , 'admins.phonenumber as phonenumber' , 'admins.gender as gender' , 'admins.country as country' , 'admins.city as city' , 'admins.address as address' , 'admins.zipcode as zipcode' ,
                        'users.id as user_id' , 'users.email as user_email' , 'users.password as user_password' , 'users.role as user_role' , 'users.status as user_status' , 
                    )
                    ->join('admins', 'admins.user_id', 'users.id')
                    ->get();

        $sellers = DB::table('users')
                    ->select(
                        'sellers.id as id' , 'sellers.fullname as fullname' , 'sellers.username as username' , 'sellers.image as image' , 'sellers.phonenumber as phonenumber' , 'sellers.gender as gender' , 'sellers.country as country' , 'sellers.city as city' , 'sellers.address as address' , 'sellers.zipcode as zipcode' ,
                        'users.id as user_id' , 'users.email as user_email' , 'users.password as user_password' , 'users.role as user_role' , 'users.status as user_status' , 
                    )
                    ->join('sellers', 'sellers.user_id', 'users.id')
                    ->get();

        $buyers = DB::table('users')
                    ->select(
                        'buyers.id as id' , 'buyers.fullname as fullname' , 'buyers.username as username' , 'buyers.image as image' , 'buyers.phonenumber as phonenumber' , 'buyers.gender as gender' , 'buyers.country as country' , 'buyers.city as city' , 'buyers.address as address' , 'buyers.zipcode as zipcode' ,
                        'users.id as user_id' , 'users.email as user_email' , 'users.password as user_password' , 'users.role as user_role' , 'users.status as user_status' , 
                    )
                    ->join('buyers', 'buyers.user_id', 'users.id')
                    ->get();

        $seller_ratings = DB::table('seller_ratings')
                    ->select(
                        'sellers.id as id' , 'sellers.fullname as fullname' , 'sellers.username as username' , 'sellers.image as image' , 'sellers.phonenumber as phonenumber' , 'sellers.gender as gender' , 'sellers.country as country' , 'sellers.city as city' , 'sellers.address as address' , 'sellers.zipcode as zipcode' ,
                        'users.id as user_id' , 'users.email as user_email' , 'users.password as user_password' , 'users.role as user_role' , 'users.status as user_status' , 
                        'seller_ratings.id as rating_id' , 'seller_ratings.rating as rating_rating' , 'seller_ratings.message as rating_message' ,
                        'buyers.id as rater_id' , 'buyers.fullname as rater_fullname' , 'buyers.username as rater_username' , 'buyers.image as rater_image' , 'buyers.phonenumber as rater_phonenumber' , 'buyers.gender as rater_gender' , 'buyers.country as rater_country' , 'buyers.city as rater_city' , 'buyers.address as rater_address' , 'buyers.zipcode as rater_zipcode' ,
                    )
                    ->leftjoin('products', 'products.id', 'seller_ratings.product_id')
                    ->leftjoin('sellers', 'sellers.id', 'products.seller_id')
                    ->leftjoin('users', 'users.id', 'sellers.user_id')
                    ->leftjoin('buyers', 'buyers.id', 'seller_ratings.buyer_id')
                    ->orderByDesc('seller_ratings.created_at')
                    ->get();

        $buyer_ratings = DB::table('buyer_ratings')
                    ->select(
                        'buyers.id as id' , 'buyers.fullname as fullname' , 'buyers.username as username' , 'buyers.image as image' , 'buyers.phonenumber as phonenumber' , 'buyers.gender as gender' , 'buyers.country as country' , 'buyers.city as city' , 'buyers.address as address' , 'buyers.zipcode as zipcode' ,
                        'users.id as user_id' , 'users.email as user_email' , 'users.password as user_password' , 'users.role as user_role' , 'users.status as user_status' , 
                        'buyer_ratings.id as rating_id' , 'buyer_ratings.rating as rating_rating' , 'buyer_ratings.message as rating_message' ,
                        'sellers.id as rater_id' , 'sellers.fullname as rater_fullname' , 'sellers.username as rater_username' , 'sellers.image as rater_image' , 'sellers.phonenumber as rater_phonenumber' , 'sellers.gender as rater_gender' , 'sellers.country as rater_country' , 'sellers.city as rater_city' , 'sellers.address as rater_address' , 'sellers.zipcode as rater_zipcode' ,
                    )
                    ->leftjoin('buyers', 'buyers.id', 'buyer_ratings.buyer_id')
                    ->leftjoin('sellers', 'sellers.id', 'buyer_ratings.buyer_id')
                    ->leftjoin('users', 'users.id', 'buyers.user_id')
                    ->orderByDesc('buyer_ratings.created_at')
                    ->get();



        $data = [
            'sellers' => $sellers,
            'admins' => $admins,
            'buyers' => $buyers,
            'roles' => $roles,
            'status' => $status,
            'seller_ratings' => $seller_ratings,
            'buyer_ratings' => $buyer_ratings
            
        ];

        return view('user.index', ['data' => $data]);
    }

    public function userUpdate(Request $request){
        $user = User::find($request->user_id);
        $user->status = $request->user_status;
        $user->save();
    }

    public function userCreateIndex(){
        return view('admin.create');
    }

    protected function userCheck(Request $request)
    {
        request()->validate([
            'user.email' => ['required', 'string', 'email:rfc,dns', 'max:255','unique:users,email'],
            'user.password' => ['required', 'string', 'min:8'],
        ],
        [
            'unique' => 'The email has already been taken.'
        ]);
    }

    protected function userCreate(Request $data){
        $this->validate($data, [
            'username' => 'required|string|unique:admins,username',
            'fullname' => 'required|string',
            'phonenumber' => 'required|numeric|min:8',
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'zipcode' => 'required|numeric',
        ]);

        $user = User::create([
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'role' => $data->role
        ]);

        $this->createAdminProfile($data, $user->id);        

        return $user;
    }
    protected function createAdminProfile(Request $data, $userid){
        
        $admin = Admin::create([
            'username' => $data->username,
            'fullname' => $data->fullname,
            'phonenumber' => $data->phonenumber,
            'gender' => $data->gender,
            'country' => $data->country,
            'city' => $data->city,
            'address' => $data->address,
            'zipcode' => $data->zipcode,
            'user_id' => $userid,
        ]);

        return $admin;

    }
}
