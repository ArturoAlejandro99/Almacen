<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteCoilProduct extends Model
{
    use HasFactory;

    public function whiteCoilProducts()
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

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        {
            $fechaStart = substr($fecha, 0, 10);
            $fechaEnd = substr($fecha, -10, 10);

            $query->whereBetween('fAdquisicion', [$fechaStart, $fechaEnd]);
        }
    }
}
