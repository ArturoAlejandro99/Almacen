<?php

namespace App\Http\Controllers;

use App\Models\Destroy;
use Illuminate\Http\Request;

class DestroyController extends Controller
{

    public function store(Request $request){

        $destroy = new Destroy();
        $destroy->nomenclatura = $request->nomenclatura;
        $destroy->fArribo = $request->fArribo;
        $destroy->peso = $request->peso;
        $destroy->type =  $request->type;
        $destroy->save();

        switch($destroy->type){
            case ('App\Models\Coil'):
                return redirect()->route('coil.index')->with('eliminar', 'ok');
            case('App\Models\Ribbon'):
                return redirect()->route('coilProduct.index')->with('eliminar', 'ribbon');
            case('App\Models\CoilReel'):
                return redirect()->route('coilProduct.index')->with('eliminar', 'huesoBobina');
            case('App\Models\WasteRibbon'):
                return redirect()->route('coilProduct.index')->with('eliminar', 'wasteRibbon');
            case('App\Models\Bag'):
                return redirect()->route('ribbonProduct.index')->with('eliminar', 'ok');
            case('App\Models\WasteBag'):
                return redirect()->route('ribbonProduct.index')->with('eliminar', 'wasteBag');
            case('App\Models\RibbonReel'):
                return redirect()->route('ribbonProduct.index')->with('eliminar', 'ribbonReel');
            case('App\Models\WhiteCoil'):
                return redirect()->route('whiteCoil.index')->with('eliminar', 'ok');
            case('App\Models\WhiteRibbon'):
                return redirect()->route('whiteCoilProduct.index')->with('eliminar', 'whiteRibbon');
            case('App\Models\WhiteWaste'):
                return redirect()->route('whiteCoilProduct.index')->with('eliminar', 'whiteWaste');
            case('App\Models\WhiteRibbonReel'):
                return redirect()->route('whiteCoilProduct.index')->with('eliminar', 'ok');
            case('App\Models\WhiteWasteRibbon'):
                return redirect()->route('whiteCoilProduct.index')->with('eliminar', 'ok');
        }
    }

    public function reporte(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para estos campos ya que se valida si es null
        //en sus scope()        
        $fechaAlta = $request->fechaAlta;
        $fechaEliminacion = $request->fechaEliminacion;

        $destroys = Destroy::fechaAlta($fechaAlta)
                            ->fechaEliminacion($fechaEliminacion)
                            ->orderBy($orderBy, $order)
                            ->get();

        return $request->ajax() ? response()->json(view('destroys.reporteria', compact('destroys', 'order', 'orderBy', 'fechaAlta', 'fechaEliminacion'))->render())
                    : view('destroys.reporteria', compact('destroys', 'order', 'orderBy', 'fechaAlta', 'fechaEliminacion'));
    }
}
