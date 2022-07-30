<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhiteCoil;
use App\Models\WhiteCoil;
use App\Models\Provider;
use App\Models\CoilType;
use App\Models\WhiteRibbonProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhiteCoilController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:whiteCoil.create')->only('createProduct', 'store');
    $this->middleware('can:whiteCoil.edit')->only('edit', 'update');
    $this->middleware('can:whiteCoil.destroy')->only('destroy');
    }
    
    public function index(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para estos campo ya que se valida si es null
        //en sus scope()
        $nomenclatura = $request->nomenclatura;
        $status = $request->status;
        $tipo = $request->tipo;
        $fecha = $request->fecha;

        $whiteCoils = WhiteCoil::leftjoin('coil_types', 'white_coils.coil_type_id', '=', 'coil_types.id')
            ->select('white_coils.id', 'white_coils.nomenclatura','white_coils.fArribo', 'white_coils.status', 'white_coils.coil_type_id', 'coil_types.alias')
            ->nomenclatura($nomenclatura)
            ->status($status)
            ->tipo($tipo)
            ->fecha($fecha)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = WhiteCoil::select('status')
            ->distinct()
            ->get();

        $allTypes = WhiteCoil::join('coil_types', 'white_coils.coil_type_id', '=', 'coil_types.id')
            ->select('alias')
            ->distinct()
            ->get();

        return $request->ajax() ? response()->json(view('whiteCoils.index', compact('whiteCoils', 'allStatus', 'allTypes', 'orderBy', 'nomenclatura', 'order', 'status', 'tipo'))->render())
                    : view('whiteCoils.index', compact('whiteCoils', 'allStatus', 'allTypes', 'orderBy', 'nomenclatura', 'order', 'status', 'tipo'));
    }

    public function create(){
       $providers = Provider::all();
       $coilTypes = CoilType::select('id','alias')->where('tipo','=','CENEFA')->get();
        
        return view('whiteCoils.create', compact('providers', 'coilTypes'));
    }

   /* public function createFromProvider(Provider $provider){
        return view('coils.create', compact('provider'));
    }*/
    
    public function edit(WhiteCoil $whiteCoil){
        $providers = Provider::all();
        $coilTypes = CoilType::all();

        return view('whiteCoils.edit', compact('whiteCoil', 'providers', 'coilTypes'));
    }

    public function update(StoreWhiteCoil $request, WhiteCoil $whiteCoil){
        $whiteCoil->provider_id = $request->provider_id;
        $whiteCoil->coil_type_id = $request->coil_type_id;

        $whiteCoil->nomenclatura =  $request->nomenclatura;
        $whiteCoil->status =  $request->status;
        $whiteCoil->fArribo =  $request->fArribo;
        $whiteCoil->peso =  $request->peso;
        $whiteCoil->observaciones =  $request->observaciones;
        $whiteCoil->pesoUtilizado = $request->pesoUtilizado;
        $whiteCoil->costo = $request->costo;
        
        $whiteCoil->save();

        return redirect()->route('whiteCoil.show', compact('whiteCoil'));
    }

    public function show(WhiteCoil $whiteCoil){
        $whiteRibbons =  WhiteCoil::find($whiteCoil->id);
        //Obtenemos todos los rollos relacionados a la bobina
        $whiteRibbons = $whiteRibbons->related()->get();
        //obtenemos todos las objetos relacionadas a los rollos
        $whiteRibbonProduct =  new Collection();
        foreach($whiteRibbons as $whiteRibbon ){
        $whiteRibbonProduct =  $whiteRibbonProduct->concat(WhiteRibbonProduct::where('white_ribbon_id', '=' , $whiteRibbon->white_coil_product_id)->get());
        }
        
    return view('whiteCoils.show', compact('whiteCoil', 'whiteRibbons', 'whiteRibbonProduct'));
    }

    public function store(StoreWhiteCoil $request){
        $maxId = WhiteCoil::find(DB::table('coils')->max('id'));
        $whiteCoil =  new WhiteCoil();

        if($request->provider_id != null) 
            $whiteCoil->provider_id = $request->provider_id;
        if($request->coil_type_id != null) 
            $whiteCoil->coil_type_id = $request->coil_type_id;

        $whiteCoil->nomenclatura =  $request->nomenclatura;
        $whiteCoil->status =  $request->status;
        $whiteCoil->fArribo =  $request->fArribo;
        $whiteCoil->peso =  $request->peso;
        $whiteCoil->observaciones =  $request->observaciones;
        $whiteCoil->pesoUtilizado = $request->pesoUtilizado;
        $whiteCoil->costo = $request->costo;

        $whiteCoil->save();

        return redirect()->route('whiteCoil.show', $whiteCoil);
    }

    public function destroy(WhiteCoil $whiteCoil)
    {
        foreach($whiteCoil->whiteRibbons as $whiteRibbon)
        {
            foreach($whiteRibbon->whiteWasteRibbons as $whiteWasteRibbon){
                $whiteWasteRibbon->delete();
            }

            foreach($whiteRibbon->whiteReels as $whiteReel){
                $whiteReel->delete();
            }

            $whiteRibbon->delete();
        }

        $whiteCoil->delete();

        $nomenclatura = $whiteCoil->nomenclatura;
        $fArribo = $whiteCoil->fArribo;
        $peso = $whiteCoil->peso;
        $type = 'App\Models\WhiteCoil';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('whiteCoil.index')->with('eliminar', 'ok');
    }
}
