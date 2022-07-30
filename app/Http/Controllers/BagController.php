<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBag;
use App\Models\Bag;
use App\Models\CoilProduct;
use App\Models\Ribbon;
use App\Models\Employee;
use App\Models\RibbonProduct;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;

class BagController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:bag.create')->only('createProduct', 'store');
    $this->middleware('can:bag.edit')->only('edit', 'update');
    $this->middleware('can:bag.destroy')->only('destroy');
    $this->middleware('can:bag.reporteria')->only('reporteria');
    }

    public function index()
    {
        $bags = Bag::paginate(10);
        
        return view('bags.index', compact('bags'));
    }

    public function create()
    {
        return view('bags.create');
    }

    public function createProduct(Request $request){   
        $ribbon = Ribbon::find($request->ribbon);

        ///
        $bagMeasures = array();

        foreach($ribbon->coils as $coil)
        {
            if(empty($bagMeasures))
            {
                $bagMeasures = $coil->coilType->bagMeasures;
            }
            else
            {
                $bagMeasures = array_merge($bagMeasures, $coil->coilType->bagMeasures);
            }
        }

        $combinedBagMeasures = array();
        
        foreach($bagMeasures as $bagMeasure)
        {
            $combinedBagMeasures[$bagMeasure->id] = $bagMeasure->largo . ' x ' . $bagMeasure->ancho;
        }
        ///

        $employees = Employee::all();

        $nomenclatura = $ribbon->nomenclatura . '-' . ($ribbon->bags()->count()+1);
        return view('bags.create', ['ribbonId' => $request->ribbon, 
                                    'nomenclatura' => $nomenclatura, 
                                    'employees' => $employees, 
                                    'combinedBagMeasures' => $combinedBagMeasures]);
    }

    public function store(StoreBag $request)
    {        
        $ribbon = Ribbon::find($request->ribbonId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
       // if($ribbon->peso >= ($request->peso + $ribbon->pesoUtilizado)){
            $bag = new Bag();
            
            $bag->bag_measure_id     = $request->bag_measure_id;
            $bag->fechaInicioTrabajo = $request->fechaInicioTrabajo;
            $bag->fechaFinTrabajo    = $request->fechaFinTrabajo;
            $bag->horaInicioTrabajo  = $request->horaInicioTrabajo;
            $bag->horaFinTrabajo     = $request->horaFinTrabajo;
            $bag->nomenclatura       = $request->nomenclatura;  
            $bag->clienteStock       = $request->clienteStock;
            $bag->peso               = $request->peso;
            $bag->tipoUnidad         = $request->tipoUnidad;
            $bag->cantidad           = $request->cantidad;
            $bag->status             = $request->status;
            $bag->temperatura        = $request->temperatura;
            $bag->velocidad          = $request->velocidad;
            $bag->observaciones      = $request->observaciones;
            
            $bag->save();

            //request->input('empleados') tiene los id's de los empleados
            $bag->employees()->attach($request->input('empleados'));    

            $addProduct = Bag::find($bag->id);
            $addProduct->ribbons()->attach($request->ribbonId, ['nomenclatura'=>$bag->nomenclatura,
                                        'status'=>$bag->status, 
                                        'fAdquisicion'=>$bag->fechaInicioTrabajo,
                                        'peso'=>$bag->peso,
                                        'unidad'=>$bag->tipoUnidad,
                                        'cantidad'=>$bag->cantidad,
                                        'medidaBolsa'=>$bag->bagMeasure->largo .' x '. $bag->bagMeasure->ancho . ($ribbon->whiteRibbons()->get()->isEmpty()? ' S/P' : ' C/P')]);

            //actualiza la bobina
            $ribbon->pesoUtilizado = $request->peso + $ribbon->pesoUtilizado;
            /*if($ribbon->pesoUtilizado == $ribbon->peso){
                $ribbon->status = 'TERMINADA';   
                $coilProduct = CoilProduct::where('coil_product_id','=', $ribbon->id)->first();
                $coilProduct->status = 'TERMINADA';
                $coilProduct->save();  
            }*/
                            
            $ribbon->save();
            
            return redirect()->route('bag.show', compact('bag'));  
        /* }
         //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
         else{
             return redirect()->back()->withInput($request->all())->withErrors('El peso de la bolsa sobrepasa el limite de peso del rollo');
         }*/
    }

    public function show(Bag $bag)
    {
        //obtenemos rollo relacionado
        $ribbon = $bag->ribbons()->get()->first();
        //obtenemos la bobina relacionada
        $coil = $ribbon->coils()->get()->first();
        //obtenemos las cintas relacionadas en los rollos en caso de existir
        $cinta =  $ribbon->whiteRibbons()->get();
        $tiempo1 = new DateTime($ribbon->fechaInicioTrabajo . 'T' . $ribbon->horaInicioTrabajo);
        $tiempo2 = new DateTime($ribbon->fechaFinTrabajo . 'T' . $ribbon->horaFinTrabajo);
        $tiempod = $tiempo1->diff($tiempo2);
        $minutosLaborados = $tiempod->h * 60 + $tiempod->i;

        return view('bags.show', compact('bag', 'coil', 'ribbon', 'cinta', 'minutosLaborados' ));
    }

    public function edit(Bag $bag)
    {
        $employees = Employee::all();
        
        //
        //obtenemos rollo relacionado
        $ribbon = $bag->ribbons()->get()->first();

        $bagMeasures = array();

        foreach($ribbon->coils as $coil)
        {
            if(empty($bagMeasures))
            {
                $bagMeasures = $coil->coilType->bagMeasures;
            }
            else
            {
                $bagMeasures = array_merge($bagMeasures, $coil->coilType->bagMeasures);
            }
        }

        $combinedBagMeasures = array();
        
        foreach($bagMeasures as $bagMeasure)
        {
            $combinedBagMeasures[$bagMeasure->id] = $bagMeasure->largo . ' x ' . $bagMeasure->ancho;
        }
        ///

        return view('bags.edit', compact('bag', 'employees', 'combinedBagMeasures'));
    }

    public function update(StoreBag $request, Bag $bag)
    {
        $bag->bag_measure_id     = $request->bag_measure_id;
        $bag->fechaInicioTrabajo = $request->fechaInicioTrabajo;
        $bag->fechaFinTrabajo    = $request->fechaFinTrabajo;
        $bag->horaInicioTrabajo  = $request->horaInicioTrabajo;
        $bag->horaFinTrabajo     = $request->horaFinTrabajo;
        $bag->nomenclatura       = $request->nomenclatura;  
        $bag->clienteStock       = $request->clienteStock;
        $bag->tipoUnidad         = $request->tipoUnidad;
        $bag->cantidad           = $request->cantidad;
        $bag->status             = $request->status;
        $bag->temperatura        = $request->temperatura;
        $bag->velocidad          = $request->velocidad;
        $bag->observaciones      = $request->observaciones;
        $bag->peso               = $request->peso;
              
        $bag->save();
        //request->input('empleados') tiene los id's de los empleados
        $bag->employees()->sync($request->input('empleados')); 
        

        $ribbonProduct = RibbonProduct::where('ribbon_product_id', '=', $bag->id)->where('ribbon_product_type', '=', 'App\Models\Bag')->get()->first();
        $ribbonProduct->nomenclatura = $bag->nomenclatura;
        $ribbonProduct->status = $bag->status;
        $ribbonProduct->fAdquisicion = $bag->fechaInicioTrabajo; 
        $ribbonProduct->peso = $bag->peso;
        $ribbonProduct->cantidad = $bag->cantidad;
        $ribbonProduct->tipoUnidad = $bag->tipoUnidad;
        $ribbonProduct->save();

       return redirect()->route('bag.show', $bag);
    }

    public function reporteria()
    {
        $medidasBolsas = DB::select(
            'SELECT DISTINCT ribbon_products.medidaBolsa as medida ' .
            'FROM ribbon_products ' .
            'JOIN bags ' .
            'ON bags.id = ribbon_products.ribbon_product_id ' .
            "WHERE ribbon_products.ribbon_product_type = 'App\\\Models\\\Bag' AND bags.status = 'DISPONIBLE' " .
            'ORDER BY ribbon_products.medidaBolsa'
        );
        
        $cantidadesBolsas = DB::select(
            'SELECT SUM(bags.cantidad) as suma_cantidad, bags.tipoUnidad, ribbon_products.medidaBolsa as medida ' .
            'FROM ribbon_products ' .
            'JOIN bags ' .
            'ON bags.id = ribbon_products.ribbon_product_id ' .
            "AND ribbon_products.ribbon_product_type = 'App\\\Models\\\Bag' AND bags.status = 'DISPONIBLE' " .
            'GROUP BY ribbon_products.medidaBolsa, bags.tipoUnidad ' .
            'ORDER BY ribbon_products.medidaBolsa, bags.tipoUnidad DESC'
        );
        
        return view('bags.reporteria', compact('medidasBolsas', 'cantidadesBolsas'));
    }

    public function destroy(Bag $bag)
    {        
        //Eliminamos las relaciones del wasteBag con ribbons  
        foreach($bag->ribbons as $ribbon)
        {
            $ribbon->bags()->detach($bag);           
        }
        
        //Eliminamos el registro de wasteBag desde su tabla 'wasteBag'
        $bag->delete();

        $nomenclatura = $bag->nomenclatura;
        $fArribo = $bag->fechaInicioTrabajo;
        $peso = $bag->peso;
        $type = 'App\Models\Bag';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('ribbonProduct.index')->with('eliminar', 'ok');
    }
    
    public function reporteriaPDF()
    {
        $medidasBolsas = DB::select(
            'SELECT DISTINCT ribbon_products.medidaBolsa as medida ' .
            'FROM ribbon_products ' .
            'JOIN bags ' .
            'ON bags.id = ribbon_products.ribbon_product_id ' .
            "WHERE ribbon_products.ribbon_product_type = 'App\\\Models\\\Bag' AND bags.status = 'DISPONIBLE' " .
            'ORDER BY ribbon_products.medidaBolsa'
        );
        
        $cantidadesBolsas = DB::select(
            'SELECT SUM(bags.cantidad) as suma_cantidad, bags.tipoUnidad, ribbon_products.medidaBolsa as medida ' .
            'FROM ribbon_products ' .
            'JOIN bags ' .
            'ON bags.id = ribbon_products.ribbon_product_id ' .
            "AND ribbon_products.ribbon_product_type = 'App\\\Models\\\Bag' AND bags.status = 'DISPONIBLE' " .
            'GROUP BY ribbon_products.medidaBolsa, bags.tipoUnidad ' .
            'ORDER BY ribbon_products.medidaBolsa, bags.tipoUnidad DESC'
        );
        
        return view('bags.reporteriaPDF', compact('medidasBolsas', 'cantidadesBolsas'));
    }
}
