<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use Auth;

class SellerController extends Controller
{
    public function index(){
        $userprofile = Seller::find(Auth::user()->seller->id);
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

        $userprofile = Seller::find(Auth::user()->seller->id);
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

            $file_name = Auth::user()->seller->username.'.'.$request->file('image')->extension();
            $file_path = $request->file('image')->storeAs('img/user', $file_name, 'public');

            $userprofile = Seller::where('username', Auth::user()->seller->username)->first();
            $userprofile->image = "/storage/".$file_path;
            $userprofile->save();
            
            return $file_path;
        }
    }

    public function overview(){
        $total_ravenue = DB::table('payments')
                        ->select(DB::raw('sum(payments.amount) as total_ravenue'))
                        ->leftjoin('offers', 'payments.offer_id', 'offers.id')
                        ->leftjoin('products', 'offers.product_id', 'products.id')
                        ->where('products.seller_id', '=', Auth::user()->seller->id)
                        ->where('payments.status', '=', 'Success')
                        ->get();

        $completed_orders = DB::table('orders')
                        ->select(DB::raw('count(orders.id) as orderNum'))
                        ->leftjoin('payments', 'orders.payment_id', 'payments.id')
                        ->leftjoin('offers', 'payments.offer_id', 'offers.id')
                        ->leftjoin('products', 'offers.product_id', 'products.id')
                        ->where('products.seller_id', '=', Auth::user()->seller->id)
                        ->where('orders.status', '=', 'Completed')
                        ->get();
        
        $pending_orders = DB::table('orders')
                        ->select(DB::raw('count(orders.id) as orderNum'))
                        ->leftjoin('payments', 'orders.payment_id', 'payments.id')
                        ->leftjoin('offers', 'payments.offer_id', 'offers.id')
                        ->leftjoin('products', 'offers.product_id', 'products.id')
                        ->where('products.seller_id', '=', Auth::user()->seller->id)
                        ->where('orders.status', '=', 'Pending')
                        ->get();

        $total_products = Product::where('seller_id', Auth::user()->seller->id)->count();

        $top_products = DB::table('orders')
                        ->select(DB::raw('count(orders.id) as orderNum, products.name'))
                        ->leftjoin('payments', 'orders.payment_id', 'payments.id')
                        ->leftjoin('offers', 'payments.offer_id', 'offers.id')
                        ->leftjoin('products', 'offers.product_id', 'products.id')
                        ->where('products.seller_id', '=', Auth::user()->seller->id)
                        ->where('payments.status', '=', 'Success')
                        ->where('orders.status', '=', 'Completed')
                        ->groupBy('products.id')
                        ->groupBy('products.name')
                        ->orderBy('orderNum')
                        ->get();

        $avg_rating = DB::table('seller_ratings')
                        ->select(DB::raw('round(avg(seller_ratings.rating), 1) as avg_rating'))
                        ->leftjoin('products', 'seller_ratings.product_id', 'products.id')
                        ->where('products.seller_id', '=', Auth::user()->seller->id)
                        ->get();
        

        $data = [
            'total_ravenue' => $total_ravenue,
            'total_products' => $total_products,
            'completed_orders' => $completed_orders,
            'pending_orders' => $pending_orders,
            'top_products' => $top_products,
            'avg_rating' => $avg_rating,
        ];

        return view('seller.overview', ['data' => $data]);
    }
}
