<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagMeasure extends Model
{
    use HasFactory;

    public function coilType()
    {
        return $this->belongsTo('App\Models\CoilType'); 
    }

    public function bags()
    {
        return $this->hasMany('App\Models\Bag'); 
    }
}
