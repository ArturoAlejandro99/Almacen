<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoilReel;
use App\Models\CoilReel;
use App\Models\Coil;
use App\Models\CoilProduct;
use Illuminate\Http\Request;

class CoilReelController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:coilReel.create')->only('createProduct', 'store');
    $this->middleware('can:coilReel.edit')->only('edit', 'update');
    $this->middleware('can:coilReel.destroy')->only('destroy');
    }

    public function index(){
        $coilReels = CoilReel::select('nomenclatura')->get();
        $coilReels = coilReel::paginate(10);

        return view('coilReels.index', compact('coilReels'));
    }

    public function create(){
        return view('coilReels.create');
    }

    //funcion para crear relaciones con bobina
    public function createProduct(Request $request){
        $coil = Coil::find($request->coil);
        $nomenclatura = 'HUE-' . $coil->nomenclatura . '-' . ($coil->ribbons()->count()+1);
        return view('coilReels.create', ['coilId' => $request->coil, 'nomenclatura' => $nomenclatura]);
    }

    public function edit(CoilReel $coilReel){
        return view('coilReels.edit', compact('coilReel'));
    }

    public function update(StoreCoilReel $request, CoilReel $coilReel){
        $coilReel->nomenclatura =  $request->nomenclatura;
        $coilReel->peso =  $request->peso;
        $coilReel->observaciones =  $request->observaciones;
        $coilReel->fechaAlta =  $request->fechaAlta;
        $coilReel->status = $request->status;
       

        $coilReel->save();

        $coilProduct = CoilProduct::where('coil_product_id', '=', $coilReel->id)->where('coil_product_type', '=', 'App\Models\CoilReel')->get()->first();
        $coilProduct->nomenclatura = $coilReel->nomenclatura;
        $coilProduct->status = $coilReel->status;
        $coilProduct->fAdquisicion = $coilReel->fechaAlta; 
        $coilProduct->peso = $coilReel->peso;
        $coilProduct->save();

        return redirect()->route('coilReel.show', compact('coilReel'));
    }

    public function show(CoilReel $coilReel){
        $coil = $coilReel->coils()->get()->first();
        return view('coilReels.show', compact('coilReel', 'coil'));
    }

    public function store(StoreCoilReel $request)
    {

        //busca la bobina
        $coil = Coil::find($request->coilId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
       // if($coil->pesoBruto >= ($request->peso + $coil->pesoUtilizado)){

        $coilReel =  new coilReel();

        $coilReel->nomenclatura =  $request->nomenclatura;
        $coilReel->peso =  $request->peso;
        $coilReel->observaciones =  $request->observaciones;
        $coilReel->fechaAlta =  $request->fechaAlta;
        $coilReel->status = $request->status;

        $coilReel->save();
        
        $addProduct = CoilReel::find($coilReel->id);
        $addProduct->coils()->attach($request->coilId, ['nomenclatura'=>$coilReel->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$coilReel->fechaAlta,
                                     'peso' => $coilReel->peso]);
        
        $coil->pesoUtilizado = $request->peso + $coil->pesoUtilizado;
        /*if($coil->pesoUtilizado == $coil->pesoBruto){
            $coil->status = 'TERMINADA';                       
            $coil->pesoNeto = $coil->related()
                                    ->where('coil_product_type', '=', 'App\Models\Ribbon')
                                    ->orWhere('coil_product_type', '=', 'App\Models\WasteRibbon')
                                    ->sum('peso');
        }  */          
        $coil->save();
        
        return redirect()->route('coilReel.show', compact('coilReel'));  
        /*}
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso del hueso sobrepasa el limite de peso de la bobina');
        }*/
    }

    public function destroy(CoilReel $coilReel)
    {
        //Eliminamos las relaciones del whiteRibbon con whiteCoil  
        foreach($coilReel->coils as $coil)
        {
            $coil->coilReels()->detach($coilReel);
        }

        //Eliminamos el registro de whiteRibbon desde su tabla 'whiteRibbons'
        $coilReel->delete();

        $nomenclatura = $coilReel->nomenclatura;
        $fArribo = $coilReel->fechaAlta;
        $peso = $coilReel->peso;
        $type = 'App\Models\CoilReel';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('coilProduct.index')->with('eliminar', 'huesoBobina');
    }
}
