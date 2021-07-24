<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerRating extends Model
{
    use HasFactory;

    public function buyer(){
        return $table->belongsTo(Buyer::Class);
    }

    public function seller(){
        return $table->belongsTo(Seller::Class);
    }
}
