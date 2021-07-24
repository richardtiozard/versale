<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Offer;
use App\Models\Request as MyRequest;

class PaymentController extends Controller
{
    public function index($id){
        $offer_auth = Offer::find($id);

        if ($offer_auth->request->buyer_id == Auth::user()->buyer->id && $offer_auth->request->status == 'Available'){
            $offer = DB::table('offers')
                    ->select(
                        'offers.id as offer_id' ,
                        'products.id as product_id' , 'products.name as product_name' , 'products.brand as product_brand' , 'products.image as product_image' , 'products.description as product_description' , 'products.stock as product_stock' , 'products.price as product_price' ,
                        'requests.id as request_id' , 'requests.status as request_status' , 'requests.budget as request_budget' , 'requests.quantity as request_quantity' , 'requests.title as request_title' , 'requests.description as request_description' ,
                    )
                    ->leftjoin('products', 'products.id', 'offers.product_id')
                    ->leftjoin('requests', 'requests.id', 'offers.request_id')
                    ->where('offers.id', $id)
                    ->get();
            
            $buyer = DB::table('buyers')
                    ->where('buyers.id', Auth::user()->buyer->id)
                    ->get();

            $data = [
                'offer' => $offer,
                'buyer' => $buyer
            ];

            return view('payment.index', ['data' => $data]);
        }
        else{
            return redirect()->route('request.index');
        }
    }

    public function create(Request $request){

        $payment = new Payment;
        $payment->offer_id = $request->offer_id;
        $payment->amount = $request->amount;
        $payment->method = 'Credit Cards';
        $payment->status = 'Success';
        $payment->save();

        $order = new Order;
        $order->payment_id = $payment->id;
        $order->status = 'Pending';
        $order->save();

        $offer = Offer::find($request->offer_id);
        $offer->status = 'Accepted';
        $offer->save();

        return 'Success';
    }
}
