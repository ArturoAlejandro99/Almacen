<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhiteRibbon;
use App\Models\CoilProduct;
use App\Models\WhiteRibbon;
use App\Models\WhiteCoil;
use App\Models\WhiteCoilProduct;
use Illuminate\Http\Request;

class WhiteRibbonController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:whiteRibbon.create')->only('createProduct', 'store');
    $this->middleware('can:whiteRibbon.edit')->only('edit', 'update');
    $this->middleware('can:whiteRibbon.destroy')->only('destroy');
    $this->middleware('can:whiteRibbon.index')->only('index');
    }

    public function index(){
        $whiteRibbons = WhiteRibbon::select('nomenclatura', 'fechaInicioTrabajo',  'status' )->get();
        $whiteRibbons = WhiteRibbon::paginate(10);

        return view('whiteRibbons.index', compact('whiteRibbons'));
    }

    /*public function create(){

    }*/
    
    //funcion para crear relaciones con bobina
    public function createProduct(Request $request){
       // $employees = Employee::all();
        $whiteCoil = WhiteCoil::find($request->whiteCoil);
        $nomenclatura = ($whiteCoil->nomenclatura) . '-' . ($whiteCoil->whiteRibbons()->count()+1);
        return view('whiteRibbons.create', ['whiteCoilId' => $request->whiteCoil, 'nomenclatura' => $nomenclatura/*, 'employees' => $employees*/]);
    
    }

    public function edit(WhiteRibbon $whiteRibbon){
        return view('whiteRibbons.edit', compact('whiteRibbon'));
    }

    public function update(StoreWhiteRibbon $request, WhiteRibbon $whiteRibbon){
        $whiteRibbon->nomenclatura =  $request->nomenclatura;
        $whiteRibbon->status =  $request->status;
        $whiteRibbon->fArribo =  $request->fArribo;
        $whiteRibbon->largo =  $request->largo;
        $whiteRibbon->peso =  $request->peso;
        $whiteRibbon->Observaciones =  $request->Observaciones;
        $whiteRibbon->pesoUtilizado = $request->pesoUtilizado;
    
        $whiteRibbon->save();

        $whiteProduct = WhiteCoilProduct::where('white_coil_product_id', '=', $whiteRibbon->id)->where('white_coil_product_type', '=', 'App\Models\WhiteRibbon')->get()->first();
        $whiteProduct->nomenclatura = $whiteRibbon->nomenclatura;
        $whiteProduct->status = $whiteRibbon->status;
        $whiteProduct->fAdquisicion = $whiteRibbon->fArribo; 
        $whiteProduct->peso = $whiteRibbon->peso;
        $whiteProduct->save();


        return redirect()->route('whiteRibbon.show', compact('whiteRibbon'));
    }

    public function show(WhiteRibbon $whiteRibbon){
        //obtenemos la bobina relacionada al rollo
        $whiteCoil = $whiteRibbon->whiteCoils()->get()->first();
        //obtenemos todas las bolsas relacionadas al rollo
        $bags =  WhiteRibbon::find($whiteRibbon->id);
        $bag = $bags->related()->get();
        //$bag = $bags;
        return view('whiteRibbons.show', compact('whiteRibbon', 'bag', 'whiteCoil'));
    }
   

    public function store(StoreWhiteRibbon $request)
    {
        //busca la bobina
        $whiteCoil = WhiteCoil::find($request->whiteCoilId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
       // if($whiteCoil->peso >= ($request->peso + $whiteCoil->pesoUtilizado)){
          
        $whiteRibbon =  new WhiteRibbon();

        $whiteRibbon->nomenclatura =  $request->nomenclatura;
        $whiteRibbon->status =  $request->status;
        $whiteRibbon->fArribo =  $request->fArribo;
        $whiteRibbon->largo =  $request->largo;
        $whiteRibbon->peso =  $request->peso;
        $whiteRibbon->Observaciones =  $request->Observaciones;
        $whiteRibbon->pesoUtilizado = $request->pesoUtilizado;
        $pesoTotal = $whiteCoil->related()->where('white_coil_product_type', '=', 'App\Models\WhiteRibbonReel')->orWhere('white_coil_product_type', '=', 'App\Models\WhiteRibbon')->sum('peso');
        if($pesoTotal != 0){
        $pesoTotal = $pesoTotal + $request->peso;
        $costo = ($whiteCoil->costo/$pesoTotal)*$request->peso;
        foreach ($whiteCoil->whiteRibbons()->get() as $whiteRibbonRelated ){    
            $costoRelacionado = ($whiteCoil->costo/$pesoTotal)*$whiteRibbonRelated->peso;
            $whiteRibbonRelated->costo = $costoRelacionado ;
            $whiteRibbonRelated->save();

        }
        foreach ($whiteCoil->whiteWaste()->get() as $whiteWaste ){    
            $costoRelacionado = ($whiteCoil->costo/$pesoTotal)*$whiteWaste->peso;
            $whiteWaste->costo = $costoRelacionado ;
            $whiteWaste->save();
        }
        }
        else{
        $pesoTotal + $request->peso;
        $costo = $whiteCoil->costo;
        }
        $whiteRibbon->costo = $costo;
        
        $whiteRibbon->save();

        //request->input('empleados') tiene los id's de los empleados
       // $whiteRibbon->employees()->attach($request->input('empleados'));        

        $addProduct = WhiteRibbon::find($whiteRibbon->id);
        $addProduct->whiteCoils()->attach($request->whiteCoilId, ['nomenclatura'=>$whiteRibbon->nomenclatura,
                                     'status'=>$whiteRibbon->status, 
                                     'fAdquisicion'=>$whiteRibbon->fArribo,
                                     'peso' => $whiteRibbon->peso]);
        
        //actualiza la bobina
        $whiteCoil->pesoUtilizado = $request->peso + $whiteCoil->pesoUtilizado;
       // if($whiteCoil->pesoUtilizado == $whiteCoil->peso)
         //   $whiteCoil->status = 'TERMINADA';                
        $whiteCoil->save();
        
        return redirect()->route('whiteRibbon.show', compact('whiteRibbon'));  
    /*}
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso del rollo de cinta sobrepasa el limite de peso de la bobina de cinta');
        }*/

    }

    public function destroy(WhiteRibbon $whiteRibbon)
    {
        //Eliminamos las relaciones del whiteRibbon con whiteCoil  
        foreach($whiteRibbon->whiteCoils as $whiteCoil)
        {
            $whiteCoil->whiteRibbons()->detach($whiteRibbon);
        }

        //Eliminamos el registro de whiteRibbon desde su tabla 'whiteRibbons'
        $whiteRibbon->delete();

        $nomenclatura = $whiteRibbon->nomenclatura;
        $fArribo = $whiteRibbon->fArribo;
        $peso = $whiteRibbon->peso;
        $type = 'App\Models\WhiteRibbon';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('whiteCoilProduct.index')->with('eliminar', 'whiteRibbon');
    }
}
