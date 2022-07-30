<?php

namespace App\Http\Controllers;

use App\Models\WhiteCoilProduct;
use Illuminate\Http\Request;

class WhiteCoilProductController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:whiteCoilProduct.index')->only('index');
    }
    
    public function index(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para estos campo ya que se valida si es null
        //en sus scope()
        $nomenclatura = $request->nomenclatura;
        $status = $request->status;
        $fecha = $request->fecha;

        $whiteCoilProducts = WhiteCoilProduct::select('id', 'nomenclatura','fAdquisicion', 'status', 'white_coil_product_id', 'white_coil_product_type')
            ->nomenclatura($nomenclatura)
            ->status($status)
            ->fecha($fecha)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = WhiteCoilProduct::select('status')
            ->distinct()
            ->get();

        return $request->ajax() ? response()->json(view('whiteCoilProducts.index', compact('whiteCoilProducts', 'allStatus', 'orderBy', 'nomenclatura', 'order', 'status'))->render())
                    : view('whiteCoilProducts.index', compact('whiteCoilProducts', 'allStatus', 'orderBy', 'nomenclatura', 'order', 'status'));        
    }
}
