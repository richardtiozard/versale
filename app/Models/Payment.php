<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function offer(){
        return $this->belongsTo(Offer::Class);
    }

    public function order(){
        return $this->hasOne(Order::Class);
    }
}
