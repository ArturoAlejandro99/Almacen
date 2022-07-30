<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteWaste extends Model
{
    use HasFactory;

    public function whiteCoils(){
        return $this->morphToMany(WhiteCoil::class, 'white_coil_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }
}
