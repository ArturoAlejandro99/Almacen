<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destroy extends Model
{
    use HasFactory;

    public function scopeFechaAlta($query, $fechaAlta)
    {
        if($fechaAlta)
        {
            $fechaStart = substr($fechaAlta, 0, 10);
            $fechaEnd = substr($fechaAlta, -10, 10);

            $query->whereBetween('fArribo', [$fechaStart, $fechaEnd]);
        }
    }

    public function scopeFechaEliminacion($query, $fechaEliminacion)
    {
        if($fechaEliminacion)
        {
            $fechaStart = substr($fechaEliminacion, 0, 10);
            $fechaEnd = substr($fechaEliminacion, -10, 10);

            $query->whereBetween('created_at', [$fechaStart, $fechaEnd]);
        }
    }
}
