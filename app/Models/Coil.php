<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coil extends Model
{
    use HasFactory;

    //relacion muchos a muchos poliformica
    public function ribbons(){
        return $this->morphedByMany(Ribbon::class, 'coil_product');
    }

    public function coilReels(){
        return $this->morphedByMany(CoilReel::class, 'coil_product');
    }

    public function wasteRibbons(){
        return $this->morphedByMany(WasteRibbon::class, 'coil_product');
    }

    public function related()
    {
        return $this->hasMany(CoilProduct::class);
    }

    public function provider()
    {
        return $this->belongsTo('App\Models\Provider'); 
    }

    public function coilType()
    {
        return $this->belongsTo('App\Models\CoilType'); 
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

    public function scopeTipo($query, $tipo)
    {
        if($tipo)
            $query->where('alias', '=', $tipo);
    }

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        {
            $fechaStart = substr($fecha, 0, 10);
            $fechaEnd = substr($fecha, -10, 10);

            $query->whereBetween('fArribo', [$fechaStart, $fechaEnd]);
        }
    }
}
