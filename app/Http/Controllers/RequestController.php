<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as MyRequest;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;

class RequestController extends Controller
{

    public function index()
    {
        $requests = DB::table('requests')
                        ->select(DB::raw('count(offers.id) as offerNum'), 'requests.*', 'categories.image')
                        ->leftjoin('categories', 'requests.category_id', 'categories.id')
                        ->leftjoin('offers', 'requests.id', 'offers.request_id')
                        ->where('requests.buyer_id', '=', Auth::user()->buyer->id)
                        ->where('requests.status', '=', 'Available')
                        ->groupBy('requests.id')
                        ->orderByDesc('requests.created_at')
                        ->get();

        $seller_images = DB::table('requests')
                        ->select('sellers.image','sellers.username', 'requests.id')
                        ->leftjoin('offers', 'requests.id', 'offers.request_id')
                        ->leftjoin('products', 'products.id', 'offers.product_id')
                        ->leftjoin('sellers', 'sellers.id', 'products.seller_id')
                        ->where('requests.buyer_id', '=', Auth::user()->buyer->id)
                        ->where('requests.status', '=', 'Available')
                        ->get();

        $data = [
            'requests' => $requests,
            'seller_images' => $seller_images
        ];

        return view('request.index',['data' => $data]);
    }

    public function createIndex(){
        $categories = Category::all();
        return view('request.create',['categories' => $categories]);
    }

    public function create(Request $request){

        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'budget' => 'required|numeric'
        ]);

        $new_request = new MyRequest;
        $new_request->category_id = $request->category_id;
        $new_request->buyer_id = Auth::user()->buyer->id;
        $new_request->title = $request->title;
        $new_request->description = $request->description;
        $new_request->budget = $request->budget;
        $new_request->quantity = $request->quantity;
        $new_request->save();

        return $new_request;
    }

    public function destroy(Request $request){
        $requests = MyRequest::find($request->request_id);
        $requests->status = 'Not Available';
        $requests->save();
        
        return 'Successfully Closed';
    }

    public function sellerIndex(){

        $requests = DB::table('requests')
                    ->select('requests.*', 'categories.image as category_image','buyers.username','buyers.image as buyer_image', DB::raw('round(avg(buyer_ratings.rating), 1) as avg_rating'))
                    ->leftjoin('categories', 'requests.category_id', 'categories.id')
                    ->leftjoin('buyers', 'requests.buyer_id', 'buyers.id')
                    ->leftjoin('buyer_ratings', 'buyer_ratings.buyer_id', 'buyers.id')
                    ->whereIn('requests.category_id', function ($query){
                        $query->select('products.category_id')
                                ->from('products')
                                ->where('products.seller_id', Auth::user()->seller->id);
                    })
                    ->where('requests.status', 'Available')
                    ->groupBy('requests.id')
                    ->orderByDesc('requests.created_at')
                    ->get();

        $offer = DB::table('offers')
                    ->select('requests.id', DB::raw('count(distinct(offers.id)) as num_offer'))
                    ->leftjoin('requests', 'requests.id', 'offers.request_id')
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->where('products.seller_id', Auth::user()->seller->id)
                    ->groupBy('requests.id')
                    ->get();


        $data = [
            'requests' => $requests,
            'offer' => $offer,
        ];

        return view('request.sellerIndex', ['data' => $data]);
    }

    public function sellerShow($id){

        $request_auth = MyRequest::find($id);
        $product_auth = Product::where('seller_id', Auth::user()->seller->id)->get();
        $isFound = false;
        
        foreach ($product_auth as $item){
            if ($item->category_id == $request_auth->category_id){
                $isFound = true;
            }
        }


        if ( $isFound == true ){

            $request = DB::table('requests')
                    ->select('requests.*', 'categories.id as category_id', 'categories.image')
                    ->leftjoin('categories', 'requests.category_id', 'categories.id')
                    ->where('requests.id', $id)
                    ->get();

            $buyer = DB::table('buyers')
                    ->select('buyers.*', DB::raw('round(avg(buyer_ratings.rating), 1) as avg_rating'), DB::raw('count(buyer_ratings.id) as num_rating'))
                    ->join('requests', 'buyers.id', 'requests.buyer_id')
                    ->join('buyer_ratings', 'buyers.id', 'buyer_ratings.buyer_id')
                    ->where('requests.id', $id)
                    ->get();

            $products = DB::table('products')
                    ->where('products.seller_id', Auth::user()->seller->id)
                    ->orderBy('products.name')
                    ->get();

            $offers = DB::table('offers')
                    ->select('offers.*', 'products.*', 'offers.id as offer_id', 'products.id as product_id')
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->where('offers.request_id', $id)
                    ->where('products.seller_id', Auth::user()->seller->id)
                    ->orderByDesc('offers.created_at')
                    ->get();
                
            $data = [
                'request' => $request,
                'buyer' => $buyer,
                'products' => $products,
                'offers' => $offers,
            ];

            return view('request.sellerShow', ['data' => $data]);
        }
        else{
            return redirect()->route('seller.request.index');
        }

        
    }
}
