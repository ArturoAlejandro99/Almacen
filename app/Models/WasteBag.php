<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteBag extends Model
{
    use HasFactory;

    public function ribbons(){
        return $this->morphToMany(Ribbon::class, 'ribbon_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion','peso')
                    ->withTimestamps();
    }

    public function employees()
    {
        //Relación muchos a muchos Employee-Waste_Bags
        return $this->belongsToMany('App\Models\Employee'); 
    }
}
