<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::Class);
    }

    public function request(){
        return $this->belongsTo(Request::Class);
    }

    public function payment(){
        return $this->hasMany(Payment::Class);
    }
}
