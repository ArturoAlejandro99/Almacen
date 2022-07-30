<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RibbonReel extends Model
{
    use HasFactory;

    public function ribbons(){
        return $this->morphToMany(Ribbon::class, 'ribbon_product')
                    ->withPivot('nomenclatura', 'status', 'fAdquisicion', 'peso')
                    ->withTimestamps();
    }
}
