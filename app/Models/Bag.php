<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory;

    public function ribbons(){
        return $this->morphToMany(Ribbon::class, 'ribbon_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso', 'cantidad','unidad')
                    ->withTimestamps();
    }
    
    public function employees()
    {
        //Relación muchos a muchos Employee_Bag
        return $this->belongsToMany('App\Models\Employee'); 
    }

    public function bagMeasure()
    {
        return $this->belongsTo('App\Models\BagMeasure');
    }
}
