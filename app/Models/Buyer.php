<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'fullname',
        'phonenumber',
        'gender',
        'country',
        'city',
        'address',
        'zipcode',
        'image',
        'user_id',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function buyerRating(){
        return $table->hasMany(BuyerRating::Class);
    }

    public function sellerRating(){
        return $table->hasMany(SellerRating::Class);
    }

    public function request(){
        return $table->hasMany(Request::Class);
    }
}
