<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteRibbon extends Model
{
    use HasFactory;

    public function whiteCoils(){
        return $this->morphToMany(WhiteCoil::class, 'white_coil_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }

    public function whiteWasteRibbons(){
        return $this->morphedByMany(WhiteWasteRibbon::class, 'white_ribbon_product');
    }

    public function whiteReels(){
        return $this->morphedByMany(WhiteRibbonReel::class, 'white_ribbon_product');
    }

    public function ribbons(){
        return $this->morphedByMany(Ribbon::class, 'white_ribbon_product');
    }

    public function related()
    {
    return $this->hasMany(WhiteRibbonProduct::class);
    }
}
