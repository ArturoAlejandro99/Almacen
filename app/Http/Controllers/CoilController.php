<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoil;
use App\Models\Coil;
use App\Models\Provider;
use App\Models\CoilType;
use App\Models\Ribbon;
use App\Models\RibbonProduct;
use App\Models\WhiteCoilProduct;
use App\Models\WhiteRibbonProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use PDF;

class CoilController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:coil.create')->only('create', 'store');
    $this->middleware('can:coil.edit')->only('edit', 'update');
    $this->middleware('can:coil.index')->only('index');
    $this->middleware('can:coil.destroy')->only('destroy');
    $this->middleware('can:coil.reporteria')->only('reporteria');
    $this->middleware('can:coil.terminar')->only('terminar');
    $this->middleware('can:coil.produccion')->only('produccion');
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

        $coils = Coil::join('coil_types', 'coils.coil_type_id', '=', 'coil_types.id')
            ->select('coils.id', 'coils.nomenclatura','coils.fArribo', 'coils.status', 'coils.coil_type_id', 'coil_types.alias')
            ->nomenclatura($nomenclatura)
            ->status($status)
            ->tipo($tipo)
            ->fecha($fecha)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = Coil::select('status')
            ->distinct()
            ->get();

        $allTypes = Coil::join('coil_types', 'coils.coil_type_id', '=', 'coil_types.id')
            ->select('alias')
            ->distinct()
            ->get();

        return $request->ajax() ? response()->json(view('coils.index', compact('coils', 'allStatus', 'allTypes', 'orderBy', 'nomenclatura', 'order', 'status', 'tipo'))->render())
                    : view('coils.index', compact('coils', 'allStatus', 'allTypes', 'orderBy', 'nomenclatura', 'order', 'status', 'tipo'));
    }

    public function create(){
        $providers = Provider::all();
        $coilTypes = CoilType::select('id','alias')->where('tipo','=','CELOFAN')->get();
        
        return view('coils.create', compact('providers', 'coilTypes'));
    }

    public function createFromProvider(Provider $provider){
        return view('coils.create', compact('provider'));
    }
    
    public function edit(Coil $coil){
        $providers = Provider::all();
        $coilType = CoilType::select('id','alias')->where('id','=', $coil->coil_type_id)->get()->first();

        return view('coils.edit', compact('coil', 'providers', 'coilType'));
    }

    public function update(StoreCoil $request, Coil $coil){
        $coil->provider_id = $request->provider_id;
        //$coil->coil_type_id = $request->coil_type_id;

        $coil->nomenclatura =  $request->nomenclatura;
        $coil->status =  $request->status;
        $coil->fArribo =  $request->fArribo;
        $coil->pesoBruto =  $request->pesoBruto;
        $coil->pesoNeto =  $request->pesoNeto;
        $coil->observaciones =  $request->observaciones;
        $coil->diametroBobina =  $request->diametroBobina;
        $coil->diametroInterno =  $request->diametroInterno;
        $coil->diametroExterno =  $request->diametroExterno;
        $coil->largoM =  $request->largoM;
        $coil->costo =  $request->costo;
        $coil->pesoUtilizado = $request->pesoUtilizado;

        $coil->save();

        return redirect()->route('coil.show', compact('coil'));
    }

    public function show(Coil $coil){
        $ribbons =  Coil::find($coil->id);
        //Obtenemos todos los rollos relacionados a la bobina
        $ribbons = $ribbons->related()->get();
        //obtenemos todos las objetos relacionadas a los rollos
        $ribbonProduct =  new Collection();
        foreach($ribbons as $ribbon ){
            if($ribbon->coil_product_type == 'App\Models\Ribbon')
            $ribbonProduct =  $ribbonProduct->concat(RibbonProduct::where('ribbon_id', '=' , $ribbon->coil_product_id)->get());
        }
        
        return view('coils.show', compact('coil', 'ribbons', 'ribbonProduct'));
    }

    public function store(StoreCoil $request){
        $coil =  new Coil();
        //$maxId = Coil::find(DB::table('coils')->max('id'));
        $coil->provider_id = $request->provider_id;
        $coil->coil_type_id = $request->coil_type_id;
        $coil->nomenclatura =  $request->nomenclatura /*. $maxId->id*/;
        $coil->status =  $request->status;
        $coil->fArribo =  $request->fArribo;
        $coil->pesoBruto =  $request->pesoBruto;
        $coil->pesoNeto =  $request->pesoNeto;
        $coil->observaciones =  $request->observaciones;
        $coil->diametroBobina =  $request->diametroBobina;
        $coil->diametroInterno =  $request->diametroInterno;
        $coil->diametroExterno =  $request->diametroExterno;
        $coil->largoM =  $request->largoM;
        $coil->costo =  $request->costo;
        $coil->pesoUtilizado = $request->pesoUtilizado;

        $coil->save();

        return redirect()->route('coil.show', $coil);
    }  

    public function terminar(Coil $coil){
        //validaciones de que se pueda terminar la bobina
    if($coil->coilReels()->get()->isEmpty()){
    
        return redirect()->back()->withErrors('La bobina no cuenta con hueso');
    }
    foreach( $coil->ribbons()->get() as $ribbon){
        if($ribbon->reels()->get()->first() == null ){
            return redirect()->back()->withErrors('Alguno de los rollos no cuenta con hueso');
        }
        foreach($ribbon->whiteRibbons()->get() as $whiteRibbon){
                if($whiteRibbon->whiteReels()->get()->first() == null){
                    return redirect()->back()->withErrors('Alguno de los rollos de cinta blanca no cuenta con hueso');
                }
        }
    }
    
    //obtenemos el total de los metros utilizados    
    $totalMetrosRollos = $coil->ribbons()->sum('largo');
    //calculamos peso neto de bobina
    $pesoNetoBobina =  $coil->pesoBruto - $coil->coilReels()->get()->first()->peso; 
    $coil->pesoNeto = $pesoNetoBobina;
    $coil->metrosUtilizados = $totalMetrosRollos; 
    //actualizamos todos los monntos de rollos para volver a calcular
    foreach ($coil->ribbons()->get() as $ribbon){
        $ribbon->pesoCelofan = 0;
        $ribbon->pesoCinta = 0;
        $ribbon->costoCinta = 0;
        $ribbon->costoCelofan = 0;
        $ribbon->save();
        
    }
    //accedemos a todas las mermas de la bobina
    foreach($coil->wasteRibbons()->get() as $wasteRibbon){
        $wasteRibbon->costo = ($coil->costo * $wasteRibbon->peso)/ $pesoNetoBobina;
        $wasteRibbon->save();
    }

    //accedemos a todos los rollos
    foreach ($coil->ribbons()->get() as $ribbon){
    //obtenemos el peso neto del rollo, sumando los pesos de las bosas y mermas
       $pesoNetoRollo = $ribbon->related()->where('ribbon_product_type', '=', 'App\Models\Bag')->orWhere('ribbon_product_type', '=', 'App\Models\WasteBag')->sum('peso');
       //obtenemos datos de las bolsas generadas
       $ribbon->pesoNeto = $pesoNetoRollo;
       //if para validar si tiene bobinas blancas ligadas
       if ($ribbon->whiteRibbons()->get()->isEmpty() ){
        $pesoCelofan = $pesoNetoRollo;
        $ribbon->pesoCelofan = $pesoCelofan;
        $costoCelofan = ($coil->costo * $pesoCelofan) / $pesoNetoBobina;
        $ribbon->costoCelofan = $costoCelofan;
       }
       else {
        //obtenemos datos de la cinta relacionada
       foreach($ribbon->whiteRibbons()->get() as $whiteRibbon){
           //Obtenemos el peso de la cinta blanca
           $huesoCinta =  $whiteRibbon->related()->where('white_ribbon_product_type', '=', 'App\Models\WhiteRibbonReel')->first();
           //calculamos el peso neto de la cinta
           $pesoNetoCinta = ($whiteRibbon->peso - $huesoCinta->peso);
           $whiteRibbon->pesoNeto = $pesoNetoCinta; 
           //obtenemos el largo de la cinta
           $largoCinta =$whiteRibbon->related()->where('white_ribbon_product_type', '=', 'App\Models\Ribbon')/*->where('white_ribbon_product_id', '=', $ribbon->id)*/->get()->sum('largo');
           //calculamos el peso por metro de la cinta blanca
           $pesoXMetroCinta = ( $pesoNetoCinta / $largoCinta);
           $whiteRibbon->kiloMetro = round($pesoXMetroCinta,4);
           //calulamos el peso de la cinta utilizado en el rollo
           $largoCintaRollo = $whiteRibbon->related()->where('white_ribbon_product_type', '=', 'App\Models\Ribbon')->where('white_ribbon_product_id', '=', $ribbon->id)->get()->first()->largo;
           $pesoCinta = ($pesoXMetroCinta * $largoCintaRollo);
           $ribbon->pesoCinta =  $ribbon->pesoCinta + $pesoCinta;
           //calculamos el peso del celofan
           $pesoCelofan = $pesoNetoRollo - $pesoCinta;
           $ribbon->pesoCelofan = $pesoCelofan;
           //calculamos costos
           $costoCelofan = ($coil->costo * $pesoCelofan) / $pesoNetoBobina;
           $ribbon->costoCelofan = $costoCelofan;
           
           $costoCinta = ($whiteRibbon->costo * $pesoCinta) / $pesoNetoCinta;
           $ribbon->costoCinta = $ribbon->costoCinta + $costoCinta;
           //cambiamos status de rollo y ponemos como terminada
           $whiteRibbon->status = 'TERMINADA';
           $whiteRibbon->save();

           $whitecoilproduct = WhiteCoilProduct::where('white_coil_product_id', '=', $whiteRibbon->id)->where('white_coil_product_type', '=', 'App\Models\WhiteRibbon')->get()->first();
           
           $whitecoilproduct->status = 'TERMINADA';
           $whitecoilproduct->save();
           //echo 'El costo de la cinta blanca es '. $costoCinta . '<br>';
       }
    }
       $ribbon->status = 'TERMINADA';
       $tiempo1 = new DateTime($ribbon->fechaInicioTrabajo . 'T' . $ribbon->horaInicioTrabajo);
       $tiempo2 = new DateTime($ribbon->fechaFinTrabajo . 'T' . $ribbon->horaFinTrabajo);
       $tiempod = $tiempo1->diff($tiempo2);
       $minutosLaborados = $tiempod->h * 60 + $tiempod->i;
       $costoManoObra = ($ribbon->employees->sum('sueldoHora'))/60*$minutosLaborados;
       $ribbon->costoTotal =  round($ribbon->costoCelofan + $ribbon->costoCinta + $costoManoObra, 4);
       $ribbon->save();
       $coilProduct = $coil->related()
       ->where('coil_id', '=', $coil->id)
       ->where('coil_product_id', '=', $ribbon->id)
       ->where('coil_product_type', '=', 'App\Models\Ribbon')
       ->get()
       ->first();
        $coilProduct->status = 'TERMINADA';
        $coilProduct->save();
       $pesoTotalBolsas = $ribbon->related()->where('ribbon_product_type', '=', 'App\Models\Bag')->orWhere('ribbon_product_type', '=', 'App\Models\WasteBag')->sum('peso');
       foreach ($ribbon->bags()->get() as $bag){
        $bag->costoTotal = (($ribbon->costoTotal/$pesoTotalBolsas) * $bag->peso);
        $coilProduct = $ribbon->related()
                            ->where('ribbon_id', '=', $ribbon->id)
                            ->where('ribbon_product_id', '=', $bag->id)
                            ->where('ribbon_product_type', '=', 'App\Models\Bag')
                            ->get()
                            ->first();
        $coilProduct->status = 'TERMINADA';
        $coilProduct->save();
        $bag->save();
       }
       foreach($ribbon->wasteBags()->get() as $wasteBag){
        $wasteBag->costo = (($ribbon->costoTotal/$pesoTotalBolsas) * $wasteBag->peso);
        $wasteBag->save();
       }
       // echo '<br>';
    }
    $coil->status = 'TERMINADA';
    
    $coil->save();
    //echo 'El total de metros de todos los rollos es  = ' . $totalMetrosRollos;
    return redirect()->route('coil.show', $coil);
    }

    public function reporteria(){
        $providers = Provider::all();
        
        $bobinas = DB::select(
            'SELECT COUNT(coil_type_id) as cantidad, coil_type_id as medida, provider_id as proveedor, sum(pesoBruto) as peso ' .
            'FROM coils ' .
            "WHERE coils.status = 'DISPONIBLE' " .
            'GROUP BY coil_type_id, provider_id ' .
            'ORDER BY coil_type_id'
        );
        $medidas = DB::select(
            'SELECT COUNT(coils.coil_type_id) as total_de_piezas, SUM(coils.pesoBruto) as total_kg, coil_types.id, coil_types.alias ' . 
            'FROM coil_types ' . 
            'JOIN coils ' . //LEFT
            'ON coils.coil_type_id = coil_types.id ' .
            'WHERE coil_types.tipo = "CELOFAN" AND coils.status = "DISPONIBLE" ' .
            'GROUP BY coil_types.id, coil_types.alias ' .
            'ORDER BY coil_types.id'
        );
        $sumaDeTotales = DB::select(
            'SELECT COUNT(coils.coil_type_id) as suma_total_piezas, SUM(coils.pesoBruto) as suma_total_peso ' .
            'FROM coils ' .
            'JOIN coil_types '.
            'ON coil_types.id = coils.coil_type_id ' .
            'WHERE coil_types.tipo = "CELOFAN" AND coils.status = "DISPONIBLE" '
        );
        $totalesDeProveedores = DB::select(
            'SELECT COUNT(coil_type_id) as cantidad, sum(pesoBruto) as peso ' .
            'FROM coils ' .
            'WHERE coils.status = "DISPONIBLE" ' .
            'GROUP BY provider_id ' .
            'ORDER BY provider_id'
        );        
        return view('coils.reporteria', compact('providers', 'bobinas', 'medidas', 'sumaDeTotales', 'totalesDeProveedores'));
    }

    public function produccion(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'nomenclatura';
        $order = $request->order ?? 'ASC';
        
        //No es necesario der un valor por defecto para estos campos ya que se valida si es null
        //en sus scope()
        $fecha = $request->fecha;
        $fAdquisicionRollo = $request->fAdquisicionRollo;
        $fAdquisicionBolsa = $request->fAdquisicionBolsa;

        //coils
        $produccion = Coil::with(['ribbons' => function($query) use ($fAdquisicionRollo, $fAdquisicionBolsa){
            //ribbons
            $query->with(['related' => function($query) use ($fAdquisicionBolsa){
                //ribbon_products
                $query->fAdquisicion($fAdquisicionBolsa)
                    ->get();
            }]);         
        }
        , 'related' => function($query) use ($fAdquisicionRollo){
            //coil_products
            $query->fAdquisicion($fAdquisicionRollo)
                ->get();
        }])
        ->orderBy($orderBy, $order)
        ->fecha($fecha)
        ->get();
        
        //return $produccion;
        return view('coils.produccion', compact('produccion', 'orderBy', 'order'));
    }

    public function destroy(Coil $coil)
    {
        foreach($coil->ribbons as $ribbon)
        {
            foreach($ribbon->wasteBags as $wasteBag){
                $wasteBag->delete();
            }

            foreach($ribbon->bags as $bag){
                $bag->delete();
            }

            foreach($ribbon->reels as $reel){
                $reel->delete();
            }

            $ribbon->delete();
        }

        $coil->delete();

        $nomenclatura = $coil->nomenclatura;
        $fArribo = $coil->fArribo;
        $peso = $coil->pesoBruto;
        $type = 'App\Models\Coil';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('coil.index')->with('eliminar', 'ok');
    }    

    public function produccionPDF(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'nomenclatura';
        $order = $request->order ?? 'ASC';
        
        //No es necesario der un valor por defecto para estos campos ya que se valida si es null
        //en sus scope()
        $fecha = $request->fecha;
        $fAdquisicionRollo = $request->fAdquisicionRollo;
        $fAdquisicionBolsa = $request->fAdquisicionBolsa;

        //coils
        $produccion = Coil::with(['ribbons' => function($query) use ($fAdquisicionRollo, $fAdquisicionBolsa){
            //ribbons
            $query->with(['related' => function($query) use ($fAdquisicionBolsa){
                //ribbon_products
                $query->fAdquisicion($fAdquisicionBolsa)
                    ->get();
            }]);         
        }
        , 'related' => function($query) use ($fAdquisicionRollo){
            //coil_products
            $query->fAdquisicion($fAdquisicionRollo)
                ->get();
        }])
        ->orderBy($orderBy, $order)
        ->fecha($fecha)
        ->get();
        

        $pdf = PDF::loadView('coils.produccionPDF', compact('produccion'))->setPaper('a4', 'landscape');
        return $pdf->download('produccion.pdf');
        //return view('coils.test', compact('produccion'));
    }

    public function reporteriaPDF(){
        $providers = Provider::all();
        
        $bobinas = DB::select(
            'SELECT COUNT(coil_type_id) as cantidad, coil_type_id as medida, provider_id as proveedor, sum(pesoBruto) as peso ' .
            'FROM coils ' .
            "WHERE coils.status = 'DISPONIBLE' " .
            'GROUP BY coil_type_id, provider_id ' .
            'ORDER BY coil_type_id'
        );
        $medidas = DB::select(
            'SELECT COUNT(coils.coil_type_id) as total_de_piezas, SUM(coils.pesoBruto) as total_kg, coil_types.id, coil_types.alias ' . 
            'FROM coil_types ' . 
            'JOIN coils ' . //LEFT
            'ON coils.coil_type_id = coil_types.id ' .
            'WHERE coil_types.tipo = "CELOFAN" AND coils.status = "DISPONIBLE" ' .
            'GROUP BY coil_types.id, coil_types.alias ' .
            'ORDER BY coil_types.id'
        );
        $sumaDeTotales = DB::select(
            'SELECT COUNT(coils.coil_type_id) as suma_total_piezas, SUM(coils.pesoBruto) as suma_total_peso ' .
            'FROM coils ' .
            'JOIN coil_types '.
            'ON coil_types.id = coils.coil_type_id ' .
            'WHERE coil_types.tipo = "CELOFAN" AND coils.status = "DISPONIBLE" '
        );
        $totalesDeProveedores = DB::select(
            'SELECT COUNT(coil_type_id) as cantidad, sum(pesoBruto) as peso ' .
            'FROM coils ' .
            'WHERE coils.status = "DISPONIBLE" ' .
            'GROUP BY provider_id ' .
            'ORDER BY provider_id'
        ); 

        return view('coils.reporteriaPDF', compact('providers', 'bobinas', 'medidas', 'sumaDeTotales', 'totalesDeProveedores'));
    }
}
