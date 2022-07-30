<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoilType;
use App\Models\BagMeasure;
use App\Http\Requests\StoreCoilType;

class CoilTypeController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:coilType.create')->only('create', 'store');
    $this->middleware('can:coilType.edit')->only('edit', 'update');
    $this->middleware('can:coilType.index')->only('index');
    $this->middleware('can:coilType.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para estos campo ya que se valida si es null
        //en sus scope()
        $alias = $request->alias;
        $tipo = $request->tipo;
        
        $coilTypes = CoilType::alias($alias)
            ->tipo($tipo)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allTypes = CoilType::select('tipo')
            ->distinct()
            ->get();

        return $request->ajax() ? response()->json(view('coilTypes.index', compact('coilTypes', 'allTypes', 'orderBy', 'alias', 'order', 'tipo'))->render())
                    : view('coilTypes.index', compact('coilTypes', 'allTypes', 'orderBy', 'alias', 'order', 'tipo'));
    }

    public function create()
    {
        return view('coilTypes.create');
    }
    
    public function store(StoreCoilType $request)
    {
        if($request->has('coilTypeForm'))
        {
            $coilType = new CoilType();

            $coilType->alias         =  $request->alias;
            $coilType->anchoCm       =  $request->anchoCm;
            $coilType->largoM        =  $request->largoM;
            $coilType->densidad      =  $request->densidad;
            $coilType->material      =  $request->material;
            $coilType->calibre       =  $request->calibre;
            $coilType->tipo          =  $request->tipo;
            $coilType->observaciones =  $request->observaciones;

            $coilType->save();
        }
        else
        {
            $bagMeasure = new BagMeasure();
            
            $bagMeasure->coil_type_id  =  $request->coil_type_id;
            $bagMeasure->ancho         =  $request->ancho;
            $bagMeasure->largo         =  $request->largo;

            $bagMeasure->save();

            $coilType = $bagMeasure->coilType;
        }
        
        return redirect()->route('coilType.show', $coilType); //NOTA: Necesita el metodo location.reload(); en el ajax para funcionar
    }

    public function show(CoilType $coilType)
    {
        $bagMeasures = $coilType->bagMeasures;

        return view('coilTypes.show', compact('coilType', 'bagMeasures'));
    }

    public function edit(CoilType $coilType)
    {
        return view('coilTypes.edit', compact('coilType'));
    }

    public function update(StoreCoilType $request, $id)//$id de CoilType o BagMeasure
    {
        if($request->has('coilTypeForm'))
        {
            $coilType = CoilType::find($id);

            $coilType->alias         =  $request->alias;
            $coilType->anchoCm       =  $request->anchoCm;
            $coilType->largoM        =  $request->largoM;
            $coilType->densidad      =  $request->densidad;
            $coilType->material      =  $request->material;
            $coilType->calibre       =  $request->calibre;
            $coilType->tipo          =  $request->tipo;
            $coilType->observaciones =  $request->observaciones;

            $coilType->save();
        }
        else
        {
            $bagMeasure = BagMeasure::find($id);
            
            $bagMeasure->coil_type_id  =  $request->coil_type_id;
            $bagMeasure->ancho         =  $request->ancho;
            $bagMeasure->largo         =  $request->largo;

            $bagMeasure->save();

            $coilType = $bagMeasure->coilType;
        }
        
        return redirect()->route('coilType.show', $coilType);
    }

    public function destroy($id, Request $request)
    {
        if($request->has('coilTypeForm'))
        {
            $coilType = CoilType::find($id);

            $coilType->delete();

            return redirect()->route('coilType.index')->with('eliminar', 'ok');
        }
        else
        {
            $bagMeasure = BagMeasure::find($id);

            $coilType = $bagMeasure->coilType;
    
            $bagMeasure->delete();
    
            return redirect()->route('coilType.show', $coilType);
        }
    }
}
