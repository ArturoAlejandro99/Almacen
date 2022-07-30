<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Mime\Exception\RfcComplianceException;

class Ribbon extends Model
{
    use HasFactory;

    public function coils(){
        return $this->morphToMany(Coil::class, 'coil_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }

    public function whiteRibbons(){
        return $this->morphToMany(WhiteRibbon::class, 'white_ribbon_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso', 'largo')
                    ->withTimestamps();
    }

    public function wasteBags(){
        return $this->morphedByMany(WasteBag::class, 'ribbon_product');
    }

    public function bags(){
        return $this->morphedByMany(Bag::class, 'ribbon_product');
    }

    public function reels(){
        return $this->morphedByMany(RibbonReel::class, 'ribbon_product');
    }

    public function related()
    {
    return $this->hasMany(RibbonProduct::class);
    }

    public function employees()
    {
        //Relación muchos a muchos Employee_Ribbon
        return $this->belongsToMany('App\Models\Employee');
    }
}
