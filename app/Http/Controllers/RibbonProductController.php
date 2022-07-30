<?php

namespace App\Http\Controllers;

use App\Models\RibbonProduct;
use Illuminate\Http\Request;

class RibbonProductController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:ribbonProduct.index')->only('index');
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
        $medida = $request->medida;

        $ribbonProduct = RibbonProduct::select('id', 'nomenclatura', 'medidaBolsa', 'peso', 'fAdquisicion', 'status', 'ribbon_product_id', 'ribbon_product_type')
            ->nomenclatura($nomenclatura)
            ->status($status)
            ->medida($medida)
            ->fecha($fecha)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = RibbonProduct::select('status')
            ->distinct()
            ->get();

        $allMedidas = RibbonProduct::select('medidaBolsa')
            ->distinct()
            ->get();
        
        return $request->ajax() ? response()->json(view('ribbonProducts.index', compact('ribbonProduct', 'allStatus', 'allMedidas', 'orderBy', 'nomenclatura', 'order', 'status', 'medida'))->render())
                    : view('ribbonProducts.index', compact('ribbonProduct', 'allStatus', 'allMedidas', 'orderBy', 'nomenclatura', 'order', 'status', 'medida'));
    }

    public function create(){
        return view('ribbon.create');
    }

    public function edit(RibbonProduct $ribbonProduct){
        return view('ribbonProduct.edit', compact('ribbonProduct'));
    }

    public function update(Request $request, RibbonProduct $ribbonProduct){
        $ribbonProduct->nomenclatura =  $request->nomenclatura;
        $ribbonProduct->status =  $request->status;
        $ribbonProduct->fArribo =  $request->fArribo;
        $ribbonProduct->pesoBruto =  $request->pesoBruto;
        $ribbonProduct->pesoNeto =  $request->pesoNeto;
        $ribbonProduct->observaciones =  $request->observaciones;
        $ribbonProduct->diametroBobina =  $request->diametroBobina;
        $ribbonProduct->diametroInterno =  $request->ddiametroInterno;
        $ribbonProduct->diametroExterno =  $request->diametroExterno;
        $ribbonProduct->largoM =  $request->largoM;
        $ribbonProduct->costo =  $request->costo;
        $ribbonProduct->provider_id = $request->provider_id;

        $ribbonProduct->save();

        return redirect()->route('ribbonProducts.show', compact('ribbonProduct'));
    }

    public function show(RibbonProduct $ribbonProduct){

        return view('ribbonProducts.show', compact('ribbonProduct'));
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

        $ribbonProduct =  new RibbonProduct();

        $ribbonProduct->nomenclatura =  $request->nomenclatura;
        $ribbonProduct->status =  $request->status;
        $ribbonProduct->fArribo =  $request->fArribo;
        $ribbonProduct->pesoBruto =  $request->pesoBruto;
        $ribbonProduct->pesoNeto =  $request->pesoNeto;
        $ribbonProduct->observaciones =  $request->observaciones;
        $ribbonProduct->diametroBobina =  $request->diametroBobina;
        $ribbonProduct->diametroInterno =  $request->ddiametroInterno;
        $ribbonProduct->diametroExterno =  $request->diametroExterno;
        $ribbonProduct->largoM =  $request->largoM;
        $ribbonProduct->costo =  $request->costo;
        $ribbonProduct->provider_id = $request->provider_id;

        $ribbonProduct->save();
        //return $request->all();
    }
}
