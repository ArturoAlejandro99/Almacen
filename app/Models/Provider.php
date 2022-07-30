<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function coils()
    {
        return $this->hasMany('App\Models\Coil');
    }

    public function whiteCoils()
    {
        return $this->hasMany('App\Models\WhiteCoil');
    }

    public function scopeNombreEmpresa($query, $nombreEmpresa)
    {
        if($nombreEmpresa)
            $query->where('nombreEmpresa', 'LIKE', "%$nombreEmpresa%");
    }
}
