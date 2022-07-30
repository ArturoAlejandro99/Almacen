<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RibbonProduct extends Model
{
    use HasFactory;

    public function bagProducts()
    {
        return $this->morphTo();
    }

    public function scopeNomenclatura($query, $nomenclatura)
    {
        if($nomenclatura)
            $query->where('nomenclatura', 'LIKE', "%$nomenclatura%");
    }

    public function scopeStatus($query, $status)
    {
        if($status)
            $query->where('status', '=', $status);
    }

    public function scopeMedida($query, $medida)
    {
        if($medida)
            $query->where('medidaBolsa', '=', $medida);
    }

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        {
            $fechaStart = substr($fecha, 0, 10);
            $fechaEnd = substr($fecha, -10, 10);

            $query->whereBetween('fecha', [$fechaStart, $fechaEnd]);
        }
    }

    public function scopeFAdquisicion($query, $fAdquisicion)
    {
        if($fAdquisicion)
        {
            $fechaStart = substr($fAdquisicion, 0, 10);
            $fechaEnd = substr($fAdquisicion, -10, 10);

            $query->whereBetween('fAdquisicion', [$fechaStart, $fechaEnd]);
        }
    }
}
