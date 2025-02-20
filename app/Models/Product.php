<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // Mutators Method save in database with your format

    public function setDescriptionAttribute($value){
        $this->attributes['description'] = strtolower($value); 
    }

    //Accessor Method to Get from database with your format
    public function getNameAttribute($value){
        return ucwords($value); 
    }
}
