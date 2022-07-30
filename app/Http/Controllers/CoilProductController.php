<?php

namespace App\Http\Controllers;

use App\Models\CoilProduct;
use Illuminate\Http\Request;

class CoilProductController extends Controller
{
    public function __construct()
    {
    $this->middleware('can:coilProduct.index')->only('index');
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

        $coilProducts = CoilProduct::select('id', 'nomenclatura', 'peso','fAdquisicion', 'status', 'coil_product_type', 'coil_product_id')
            ->nomenclatura($nomenclatura)
            ->status($status)
            ->fecha($fecha)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = CoilProduct::select('status')
            ->distinct()
            ->get();

        return $request->ajax() ? response()->json(view('coilProducts.index', compact('coilProducts', 'allStatus', 'orderBy', 'nomenclatura', 'order', 'status'))->render())
                    : view('coilProducts.index', compact('coilProducts', 'allStatus', 'orderBy', 'nomenclatura', 'order', 'status'));
    }

    public function create(){
        return view('ribbon.create');
    }

    public function edit(CoilProduct $coilProduct){
        return view('coilProducts.edit', compact('coilProduct'));
    }

    public function update(Request $request, CoilProduct $coilProduct){
        $coilProduct->nomenclatura =  $request->nomenclatura;
        $coilProduct->status =  $request->status;
        $coilProduct->fArribo =  $request->fArribo;
        $coilProduct->pesoBruto =  $request->pesoBruto;
        $coilProduct->pesoNeto =  $request->pesoNeto;
        $coilProduct->observaciones =  $request->observaciones;
        $coilProduct->diametroBobina =  $request->diametroBobina;
        $coilProduct->diametroInterno =  $request->ddiametroInterno;
        $coilProduct->diametroExterno =  $request->diametroExterno;
        $coilProduct->largoM =  $request->largoM;
        $coilProduct->costo =  $request->costo;
        $coilProduct->provider_id = $request->provider_id;

        $coilProduct->save();

        return redirect()->route('coilProducts.show', compact('coilProduct'));
    }

    public function show(CoilProduct $coilProduct){

        return view('coilProducts.show', compact('coilProduct'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nomenclatura' => 'required',
            'status' => 'required',
            'fArribo' => 'required',
            'pesoBruto' => 'required',
            'pesoNeto' => 'required',
            'largoM' => 'required',
            'costo' => 'required',
            'provider_id' => 'required'
        ]);

        $coilProduct =  new CoilProduct();

        $coilProduct->nomenclatura =  $request->nomenclatura;
        $coilProduct->status =  $request->status;
        $coilProduct->fArribo =  $request->fArribo;
        $coilProduct->pesoBruto =  $request->pesoBruto;
        $coilProduct->pesoNeto =  $request->pesoNeto;
        $coilProduct->observaciones =  $request->observaciones;
        $coilProduct->diametroBobina =  $request->diametroBobina;
        $coilProduct->diametroInterno =  $request->ddiametroInterno;
        $coilProduct->diametroExterno =  $request->diametroExterno;
        $coilProduct->largoM =  $request->largoM;
        $coilProduct->costo =  $request->costo;
        $coilProduct->provider_id = $request->provider_id;

        $coilProduct->save();
        //return $request->all();
    }
}
