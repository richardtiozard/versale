<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'stock',
        'price',
        'image',
        'seller_id',
        'category_id',

    ];

    public function seller(){
        return $table->belongsTo(Seller::Class);
    }

    public function category(){
        return $table->belongsTo(Category::Class);
    }

    public function sellerRating(){
        return $table->hasMany(SellerRating::Class);
    }

    public function offer(){
        return $this->hasMany(Offer::Class);
    }
}
