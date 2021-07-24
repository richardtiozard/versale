<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::Class);
    }

    public function buyer(){
        return $this->belongsTo(Buyer::Class);
    }

    public function offer(){
        return $this->belongsTo(Offer::Class);
    }
}
