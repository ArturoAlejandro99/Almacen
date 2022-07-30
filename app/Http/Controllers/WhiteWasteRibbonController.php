<?php

namespace App\Http\Controllers;

use App\Models\CoilProduct;
use App\Models\WhiteCoilProduct;
use App\Models\WhiteRibbon;
use App\Models\WhiteRibbonProduct;
use App\Models\WhiteWasteRibbon;
use Illuminate\Http\Request;

class WhiteWasteRibbonController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:whiteWasteRibbon.create')->only('createProduct', 'store');
    $this->middleware('can:whiteWasteRibbon.edit')->only('edit', 'update');
    $this->middleware('can:whiteWasteRibbon.destroy')->only('destroy');
    }

    public function index()
    {
        $whiteWasteRibbons = WhiteWasteRibbon::paginate(10);
        
        return view('whiteWasteRibbons.index', compact('whiteWasteRibbons'));
    }

    public function create()
    {
        return view('whiteWasteRibbons.create');
    }

    public function createProduct(Request $request){
        $whiteRibbon = WhiteRibbon::find($request->whiteRibbon);
        $nomenclatura = 'MER-' . $whiteRibbon->nomenclatura . '-' . ($whiteRibbon->whiteWasteRibbons()->count()+1);
        return view('whiteWasteRibbons.create', ['whiteRibbonId' => $request->whiteRibbon, 'nomenclatura' => $nomenclatura]);
    }

    public function store(Request $request)
    {
        //busca la bobina
        $whiteRibbon = WhiteRibbon::find($request->whiteRibbonId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
        //if($whiteRibbon->peso >= ($request->peso + $whiteRibbon->pesoUtilizado)){
        $whiteWasteRibbons = new WhiteWasteRibbon();

        $whiteWasteRibbons->fAlta = $request->fAlta;
        $whiteWasteRibbons->peso           = $request->peso;
        $whiteWasteRibbons->largo          = $request->largo;
        $whiteWasteRibbons->observaciones  = $request->observaciones;
        $whiteWasteRibbons->status         = $request->status;
        $whiteWasteRibbons->costo     = $request->costo;
        $whiteWasteRibbons->nomenclatura   = $request->nomenclatura;


        $whiteWasteRibbons->save();

        $addProduct = WhiteWasteRibbon::find($whiteWasteRibbons->id);
        $addProduct->whiteRibbons()->attach($request->whiteRibbonId, ['nomenclatura'=>$whiteWasteRibbons->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$whiteWasteRibbons->fAlta,
                                     'peso'=>$whiteWasteRibbons->peso,
                                     'largo' => $request->largo]);

        $whiteRibbon->pesoUtilizado = $request->peso + $whiteRibbon->pesoUtilizado;
        if($whiteRibbon->pesoUtilizado == $whiteRibbon->peso){
        $whiteRibbon->status = 'TERMINADA';         
        //actualizando tabla intermedia de bobinas y rollos (whiteCilProduct)          
        $whiteCoilProduct = WhiteCoilProduct::where('white_coil_product_id','=', $whiteRibbon->id)->first();
        $whiteCoilProduct->status = 'TERMINADA';
        $whiteCoilProduct->save();

        }        
        $whiteRibbon->save();
                                    
        return redirect()->route('whiteRibbon.show', compact('whiteRibbon'));  
       /* }
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso del hueso sobrepasa el limite de peso del rollo');
        }*/
    }

    public function show(WhiteWasteRibbon $whiteWasteRibbon)
    {
        //obtenemos rollo relacionado
        $whiteRibbon = $whiteWasteRibbon->whiteRibbons()->get()->first();
        //obtenemos la bobina relacionada
        $whiteCoil = $whiteRibbon->whiteCoils()->get()->first();

        return view('whiteWasteRibbons.show', compact('whiteWasteRibbon', 'whiteRibbon', 'whiteCoil'));
    }

    public function edit(WhiteWasteRibbon $whiteWasteRibbon)
    {
        return view('whiteWasteRibbons.edit', compact('whiteWasteRibbon'));
    }

    public function update(Request $request, WhiteWasteRibbon $whiteWasteRibbon)
    {
        $whiteWasteRibbon->fAlta = $request->fAlta;
        $whiteWasteRibbon->peso           = $request->peso;
        $whiteWasteRibbon->largo          = $request->largo;
        $whiteWasteRibbon->observaciones  = $request->observaciones;
        $whiteWasteRibbon->status         = $request->status;
        $whiteWasteRibbon->costo     = $request->costo;
        $whiteWasteRibbon->nomenclatura   = $request->nomenclatura;

        $whiteWasteRibbon->save();

        $whiteProduct = WhiteRibbonProduct::where('white_ribbon_product_id', '=', $whiteWasteRibbon->id)->where('white_ribbon_product_type', '=', 'App\Models\WhiteWasteRibbon')->get()->first();
        $whiteProduct->nomenclatura = $whiteWasteRibbon->nomenclatura;
        $whiteProduct->status = $whiteWasteRibbon->status;
        $whiteProduct->fAdquisicion = $whiteWasteRibbon->fArribo; 
        $whiteProduct->peso = $whiteWasteRibbon->peso;
        $whiteProduct->save();

        return redirect()->route('whiteWasteRibbon.show', $whiteWasteRibbon);
    }

    public function destroy(WhiteWasteRibbon $whiteWasteRibbon)
    {
        //Eliminamos las relaciones del whiteWasteRibbon con whiteRibbons  
        foreach($whiteWasteRibbon->whiteRibbons as $whiteRibbon)
        {
            $whiteRibbon->whiteWasteRibbons()->detach($whiteWasteRibbon);           
        }
        
        //Eliminamos el registro de whiteRibbons desde su tabla 'whiteRibbons'
        $whiteWasteRibbon->delete();

        $nomenclatura = $whiteWasteRibbon->nomenclatura;
        $fArribo = $whiteWasteRibbon->fArribo;
        $peso = $whiteWasteRibbon->peso;
        $type = 'App\Models\WhiteWasteRibbon';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

       // return redirect()->route('whiteRibbon.show', $whiteRibbon)->with('eliminar', 'whiteWasteRibbon');
    }
}
