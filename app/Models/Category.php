<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function product(){
        return $table->hasMany(Product::Class);
    }

    public function request(){
        return $table->hasMany(Category::Class);
    }
}
