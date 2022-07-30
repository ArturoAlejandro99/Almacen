<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteRibbon extends Model
{
    use HasFactory;

    public function coils(){
        return $this->morphToMany(Coil::class, 'coil_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }

    public function employees()
    {
        //Relación muchos a muchos Employee-Waste_Ribbons
        return $this->belongsToMany('App\Models\Employee'); 
    }
}
