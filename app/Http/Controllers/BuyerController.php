<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buyer;
use Auth;

class BuyerController extends Controller
{
    public function index(){
        $userprofile = Buyer::find(Auth::user()->buyer->id);
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

        $userprofile = Buyer::find(Auth::user()->buyer->id);
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

            $file_name = Auth::user()->buyer->username.'.'.$request->file('image')->extension();
            $file_path = $request->file('image')->storeAs('img/user', $file_name, 'public');

            $userprofile = Buyer::where('username', Auth::user()->buyer->username)->first();
            echo $request->username;
            $userprofile->image = "/storage/".$file_path;
            $userprofile->save();
            
            return $file_path;
        }
    }
}
