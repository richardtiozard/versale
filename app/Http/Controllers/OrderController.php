<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\BuyerRating;


class OrderController extends Controller
{
    public function index(){
        $orders = DB::table('orders')
                    ->select(
                        'orders.id as order_id' , 'orders.status as order_status' ,
                        'payments.id as payment_id' , 'payments.status as payment_status' , 'payments.method as payment_method' , 'payments.amount as payment_amount', 'payments.created_at as payment_created_at',
                        'offers.id as offer_id' , 'offers.status as offer_status' ,
                        'requests.id as request_id' , 'requests.status as request_status' , 'requests.budget as request_budget' , 'requests.quantity as request_quantity' , 'requests.title as request_title' , 'requests.description as request_description' ,
                        'products.id as product_id' , 'products.name as product_name' , 'products.brand as product_brand' , 'products.image as product_image' , 'products.description as product_description' , 'products.stock as product_stock' , 'products.price as product_price' ,
                        'sellers.id as seller_id' , 'sellers.username as seller_username' , 'sellers.image as seller_image' , 'sellers.phonenumber as seller_phonenumber' , 'sellers.gender as seller_gender' , 'sellers.country as seller_country' , 'sellers.city as seller_city' , 'sellers.address as seller_address' , 'sellers.zipcode as seller_zipcode' ,
                        'seller_ratings.id as seller_rating_id' , 'seller_ratings.rating as seller_rating_rating' , 'seller_ratings.message as seller_rating_message' ,
                    )
                    ->leftjoin('payments', 'payments.id', 'orders.payment_id')
                    ->leftjoin('offers', 'offers.id', 'payments.offer_id')
                    ->leftjoin('requests', 'requests.id', 'offers.request_id')
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->leftjoin('sellers', 'sellers.id', 'products.seller_id')
                    ->leftjoin('buyers', 'buyers.id', 'requests.buyer_id')
                    ->leftJoin('seller_ratings', function($join){
                        $join->on('seller_ratings.buyer_id', '=', 'buyers.id');
                        $join->on('seller_ratings.product_id','=','products.id'); 
                    })
                    ->where('requests.buyer_id', Auth::user()->buyer->id)
                    ->groupBy('orders.id')
                    ->orderByDesc('orders.created_at')
                    ->get();

        $data = [
            'orders' => $orders
        ];
        
        return view('order.index', ['data' => $data]);
    }

    public function sellerIndex(){

        $orders = DB::table('orders')
                    ->select(
                        'orders.id as order_id' , 'orders.status as order_status' , 'orders.created_at as order_created_at' ,
                        'payments.id as payment_id' , 'payments.status as payment_status' , 'payments.method as payment_method' , 'payments.amount as payment_amount',
                        'offers.id as offer_id' , 'offers.status as offer_status' ,
                        'requests.id as request_id' , 'requests.status as request_status' , 'requests.budget as request_budget' , 'requests.quantity as request_quantity' , 'requests.title as request_title' , 'requests.description as request_description' ,
                        'products.id as product_id' , 'products.name as product_name' , 'products.brand as product_brand' , 'products.image as product_image' , 'products.description as product_description' , 'products.stock as product_stock' , 'products.price as product_price' ,
                        'sellers.id as seller_id' , 'sellers.username as seller_username' , 'sellers.image as seller_image' , 'sellers.phonenumber as seller_phonenumber' , 'sellers.gender as seller_gender' , 'sellers.country as seller_country' , 'sellers.city as seller_city' , 'sellers.address as seller_address' , 'sellers.zipcode as seller_zipcode' ,
                        'buyers.id as buyer_id' , 'buyers.username as buyer_username' , 'buyers.image as buyer_image' , 'buyers.phonenumber as buyer_phonenumber' , 'buyers.gender as buyer_gender' , 'buyers.country as buyer_country' , 'buyers.city as buyer_city' , 'buyers.address as buyer_address' , 'buyers.zipcode as buyer_zipcode' ,
                        'buyer_ratings.id as buyer_rating_id' , 'buyer_ratings.rating as buyer_rating_rating' , 'buyer_ratings.message as buyer_rating_message' ,
                    )
                    ->leftjoin('payments', 'payments.id', 'orders.payment_id')
                    ->leftjoin('offers', 'offers.id', 'payments.offer_id')
                    ->leftjoin('requests', 'requests.id', 'offers.request_id')
                    ->leftjoin('buyers', 'buyers.id', 'requests.buyer_id')
                    ->leftjoin('buyer_ratings', 'buyers.id', 'buyer_ratings.buyer_id')
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->leftjoin('sellers', 'sellers.id', 'products.seller_id')
                    ->where('products.seller_id', Auth::user()->seller->id)
                    ->groupBy('orders.id')
                    ->orderByDesc('orders.created_at')
                    ->get();

        $data = [
            'orders' => $orders
        ];

        return view('order.sellerIndex', ['data' => $data]);
    }

    public function update(Request $request){

        $order = Order::find($request->order_id);
        $order->status = 'Completed';
        $order->save();

        $product = Product::find($request->product_id);
        $product->stock = $product->stock - $request->request_quantity;
        $product->save();

        $buyer_rating = new BuyerRating;
        $buyer_rating->seller_id = Auth::user()->seller->id;
        $buyer_rating->rating = $request->rating;
        $buyer_rating->message = $request->message;
        $buyer_rating->buyer_id = $request->buyer_id;
        $buyer_rating->save();

        return 'success';
    }
}
