<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteWasteRibbon extends Model
{
    use HasFactory;

    public function whiteRibbons(){
        return $this->morphToMany(WhiteRibbon::class, 'white_ribbon_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }
}
