<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Request as MyRequest;

class OfferController extends Controller
{
    public function Index(){
        $offers = DB::table('offers')
                    ->select('offers.id as offer_id', 'offers.status as offer_status', 'requests.id as request_id', 'requests.status as request_status', 'requests.quantity', 'products.id as product_id', 'products.name', 'products.brand', 'products.price', 'categories.subcategory2')
                    ->leftjoin('requests', 'requests.id', 'offers.request_id')
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->leftjoin('categories', 'categories.id', 'products.category_id')
                    ->where('products.seller_id', Auth::user()->seller->id)
                    ->orderByDesc('offers.created_at')
                    ->get();


        $data = [
            'offers' => $offers,
        ];
        return view('offer.index', ['data' => $data]);
    }

    public function create(Request $request){
        $offer = new Offer;
        $offer->request_id = $request->request_id;
        $offer->product_id = $request->product_id;
        $offer->status = 'Pending';
        $offer->save();

        return $offer;
    }

    public function show($id){
        $request_auth = MyRequest::find($id);

        if ($request_auth->buyer_id == Auth::user()->buyer->id){

            $offers = DB::table('offers')
                        ->select(
                            'offers.id as offer_id' , 'offers.status as offer_status' ,
                            'requests.id as request_id' , 'requests.status as request_status' , 'requests.budget as request_budget' , 'requests.quantity as request_quantity' , 'requests.title as request_title' , 'requests.description as request_description' ,
                            'categories.id as category_id' , 'categories.category as category_category' , 'categories.subcategory as category_subcategory' , 'categories.subcategory2 as category_subcategory2' , 'categories.image as category_image' ,
                            'products.id as product_id' , 'products.name as product_name' , 'products.brand as product_brand' , 'products.image as product_image' , 'products.description as product_description' , 'products.stock as product_stock' , 'products.price as product_price' ,
                            'sellers.id as seller_id' , 'sellers.username as seller_username' , 'sellers.image as seller_image' , 'sellers.phonenumber as seller_phonenumber' , 'sellers.gender as seller_gender' , 'sellers.country as seller_country' , 'sellers.city as seller_city' , 'sellers.address as seller_address' , 'sellers.zipcode as seller_zipcode' ,
                            DB::raw('round(avg(seller_ratings.rating), 1) as product_avg_rating')
                        )
                        ->leftjoin('requests', 'requests.id', 'offers.request_id')
                        ->leftjoin('categories', 'categories.id', 'requests.category_id')
                        ->leftjoin('products', 'products.id', 'offers.product_id')
                        ->leftjoin('sellers', 'sellers.id', 'products.seller_id')
                        ->leftjoin('seller_ratings', 'seller_ratings.product_id', 'products.id')
                        ->where('requests.id', $id)
                        ->where('requests.buyer_id', Auth::user()->buyer->id)
                        ->groupBy('offers.id')
                        ->get();

            $product_reviews = DB::table('offers')
                        ->select(
                            'offers.id as offer_id' ,
                            'products.id as product_id' , 'products.name as product_name' , 'products.brand as product_brand' , 'products.image as product_image' ,
                            'seller_ratings.id as seller_rating_id' , 'seller_ratings.rating as seller_rating_rating' , 'seller_ratings.message as seller_rating_message' ,
                            'buyers.id as buyer_id' , 'buyers.username as buyer_username' , 'buyers.image as buyer_image'
                        )
                        ->leftjoin('requests', 'requests.id', 'offers.request_id')
                        ->leftjoin('products', 'products.id', 'offers.product_id')
                        ->leftjoin('seller_ratings', 'seller_ratings.product_id', 'products.id')
                        ->leftjoin('buyers', 'buyers.id', 'seller_ratings.buyer_id')
                        ->where('requests.id', $id)
                        ->where('requests.buyer_id', Auth::user()->buyer->id)
                        ->get();

            $data = [
                'offers' => $offers,
                'product_reviews' => $product_reviews
            ];

            return view('offer.show', ['data' => $data]);
        }
        else{
            return redirect()->route('request.index');
        }
        
    }

    public function destroy(Request $request){
        $offers = Offer::destroy($request->offer_id);
        return 'Successfully Deleted';
    }
}
