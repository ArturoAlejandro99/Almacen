<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteRibbonProduct extends Model
{
    use HasFactory;

    public function whiteRibbonProducts()
    {
        return $this->morphTo();
    }
}
