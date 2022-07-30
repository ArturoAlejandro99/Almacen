<?php

namespace App\Http\Controllers;

use App\Models\WhiteRibbonReel;
use App\Models\WhiteRibbon;
use App\Http\Requests\StoreWhiteRibbonReel;
use App\Models\WhiteCoilProduct;
use App\Models\WhiteRibbonProduct;
use Illuminate\Http\Request;

class WhiteRibbonReelController extends Controller
{
    public function __construct()
    {
    $this->middleware('can:whiteRibbonReel.create')->only('createProduct', 'store');
    $this->middleware('can:whiteRibbonReel.edit')->only('edit', 'update');
    $this->middleware('can:whiteRibbonReel.destroy')->only('destroy');
    }
     
    public function index(){
        $whiteRibbonReel = WhiteRibbonReel::select('nomenclatura')->get();
        $whiteRibbonReel = WhiteRibbonReel::paginate(10);

        return view('WhiteRibbonReels.index', compact('whiteRibbonReel'));
    }

    public function create(){
        return view('WhiteRibbonReels.create');
    }

    //funcion para crear relaciones con bobina
    public function createProduct(Request $request){
        $whiteRibbon = WhiteRibbon::find($request->whiteRibbon);
        $nomenclatura = 'HUE-' . $whiteRibbon->nomenclatura . '-' . ($whiteRibbon->whiteReels()->count()+1);
        return view('WhiteRibbonReels.create', ['whiteRibbonId' => $request->whiteRibbon, 'nomenclatura' => $nomenclatura]);
    }

    public function edit(WhiteRibbonReel $ribbonReel){
        return view('RibbonReels.edit', compact('ribbonReel'));
    }

    public function update(StoreWhiteRibbonReel $request, WhiteRibbonReel $whiteRibbonReel){
        $whiteRibbonReel->nomenclatura =  $request->nomenclatura;
        $whiteRibbonReel->peso =  $request->peso;
        $whiteRibbonReel->observaciones =  $request->observaciones;
        $whiteRibbonReel->fechaAlta =  $request->fechaAlta;
        $whiteRibbonReel->status = $request->status;
       

        $whiteRibbonReel->save();

        $whiteProduct = WhiteRibbonProduct::where('white_ribbon_product_id', '=', $whiteRibbonReel->id)->where('white_ribbon_product_type', '=', 'App\Models\WhiteRibbonReel')->get()->first();
        $whiteProduct->nomenclatura = $whiteRibbonReel->nomenclatura;
        $whiteProduct->status = $whiteRibbonReel->status;
        $whiteProduct->fAdquisicion = $whiteRibbonReel->fechaAlta; 
        $whiteProduct->peso = $whiteRibbonReel->peso;
        $whiteProduct->save();

        return redirect()->route('whiteRibbonReel.show', compact('whiteRibbonReel'));
    }

    public function show(WhiteRibbonReel $whiteRibbonReel){
        $whiteRibbon = $whiteRibbonReel->whiteRibbons()->get()->first();
        //obtenemos la bobina relacionada
        $whiteCoil = $whiteRibbon->whiteCoils()->get()->first();
        return view('whiteRibbonReels.show', compact('whiteRibbonReel', 'whiteRibbon', 'whiteCoil'));
    }

    public function store(StoreWhiteRibbonReel $request)
    {

        //busca la bobina
        $whiteRibbon = WhiteRibbon::find($request->whiteRibbonId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
        //if($whiteRibbon->peso >= ($request->peso + $whiteRibbon->pesoUtilizado)){

        $whiteRibbonReel =  new WhiteRibbonReel();

        $whiteRibbonReel->nomenclatura =  $request->nomenclatura;
        $whiteRibbonReel->peso =  $request->peso;
        $whiteRibbonReel->observaciones =  $request->observaciones;
        $whiteRibbonReel->fechaAlta =  $request->fechaAlta;
        $whiteRibbonReel->status = $request->status;

        $whiteRibbonReel->save();
        
        $addProduct = WhiteRibbonReel::find($whiteRibbonReel->id);
        $addProduct->whiteRibbons()->attach($request->whiteRibbonId, ['nomenclatura'=>$whiteRibbonReel->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$whiteRibbonReel->fechaAlta,
                                     'peso'=>$whiteRibbonReel->peso,
                                     'largo' => '0']);
        
        $whiteRibbon->pesoUtilizado = $request->peso + $whiteRibbon->pesoUtilizado;
        /*if($whiteRibbon->pesoUtilizado == $whiteRibbon->peso){
        $whiteRibbon->status = 'TERMINADA';  
        //actualizando tabla intermedia de bobinas y rollos (whiteCilProduct)          
        $whiteCoilProduct = WhiteCoilProduct::where('white_coil_product_id','=', $whiteRibbon->id)->first();
        $whiteCoilProduct->status = 'TERMINADA';
        $whiteCoilProduct->save();
        }*/
                                 
        $whiteRibbon->save();
        
        return redirect()->route('whiteRibbon.show', compact('whiteRibbon'));  
       /* }
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso del hueso sobrepasa el limite de peso del rollo');
        }*/
    }
    
    public function destroy(WhiteRibbonReel $whiteRibbonReel)
    {
        //Eliminamos las relaciones del whiteRibbonReel con whiteRibbons  
        foreach($whiteRibbonReel->whiteRibbons as $whiteRibbon)
        {
            $whiteRibbon->whiteReels()->detach($whiteRibbonReel);           
        }
        
        //Eliminamos el registro de whiteRibbonReel desde su tabla 'whiteRibbonReel'
        $whiteRibbonReel->delete();

        $nomenclatura = $whiteRibbonReel->nomenclatura;
        $fArribo = $whiteRibbonReel->fArribo;
        $peso = $whiteRibbonReel->peso;
        $type = 'App\Models\WhiteRibbonReel';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('whiteRibbon.show', $whiteRibbon)->with('eliminar', 'whiteRibbonReel');
    }
}
