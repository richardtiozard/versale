<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRating extends Model
{
    use HasFactory;

    public function product(){
        return $table->belongsTo(Product::Class);
    }

    public function buyer(){
        return $table->belongsTo(Buyer::Class);
    }
}
