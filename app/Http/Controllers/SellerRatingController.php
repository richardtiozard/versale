<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerRating;

class SellerRatingController extends Controller
{
    public function create(Request $request){
        $sellerRating = new SellerRating;
        $sellerRating->rating = $request->rating;
        $sellerRating->message = $request->message;
        $sellerRating->product_id = $request->product_id;
        $sellerRating->buyer_id = Auth::user()->buyer->id;
        $sellerRating->save();

        return redirect()->route('order.index');
    }
}
