<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRibbon;
use App\Models\Coil;
use App\Models\CoilProduct;
use App\Models\Ribbon;
use App\Models\Employee;
use App\Models\WhiteRibbon;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class RibbonController extends Controller
{
    public function __construct()
    {
    $this->middleware('can:ribbon.create')->only('store', 'createProduct');
    $this->middleware('can:ribbon.edit')->only('edit', 'update');
    $this->middleware('can:ribbon.reporteria')->only('reporteria');
    $this->middleware('can:ribbon.destroy')->only('destroy');
    }

    public function index(){
        $ribbons = Ribbon::select('nomenclatura', 'fechaInicioTrabajo',  'status' )->get();
        $ribbons = Ribbon::paginate(10);

        return view('ribbons.index', compact('ribbons'));
    }

    /*public function create(){

    }*/
    
    //funcion para crear relaciones con bobina
    public function createProduct(Request $request){
        $employees = Employee::all();
        //$nomenclatura = Coil::select('nomenclatura')->where('id', 1)->get()->first()->nomenclatura;
        $coil = Coil::find($request->coil);
        $nomenclatura = ($coil->nomenclatura) . '-' . ($coil->ribbons()->count()+1);
        $cintaBlancas = WhiteRibbon::where('status', '=', 'DISPONIBLE')->get();
        return view('ribbons.create', ['coilId' => $request->coil, 'nomenclatura' => $nomenclatura, 'employees' => $employees, 'cintaBlancas' => $cintaBlancas]);
    }

    public function edit(Ribbon $ribbon){
        $employees = Employee::all(); 
        $cintaBlancas = WhiteRibbon::where('status', '=', 'DISPONIBLE')->get();
        return view('ribbons.edit', compact('ribbon', 'employees', 'cintaBlancas'));
    }

    public function update(StoreRibbon $request, Ribbon $ribbon){
        //echo $request->all();
        //return $request->all();
        $ribbon->nomenclatura =  $request->nomenclatura;
        $ribbon->status =  $request->status;
        $ribbon->fechaInicioTrabajo =  $request->fechaInicioTrabajo;
        $ribbon->horaInicioTrabajo =  $request->horaInicioTrabajo;
        $ribbon->largo =  $request->largo;
        $ribbon->fechaFinTrabajo =  $request->fechaFinTrabajo;
        $ribbon->horaFinTrabajo =  $request->horaFinTrabajo;
        $ribbon->peso =  $request->peso;
        $ribbon->pesoUtilizado =  $request->pesoUtilizado;
        $ribbon->temperatura =  $request->temperatura;
        $ribbon->velocidad = $request->velocidad;
        $ribbon->observaciones = $request->observaciones;

        $ribbon->save();

        //request->input('empleados') tiene los id's de los empleados
        if(empty($request->input('empleados')) != true )
        $ribbon->employees()->sync($request->input('empleados'));
        
        //if(empty($request->input('cintas')) != true or empty($request->input('largos')) != true)
        $ribbon->whiteRibbons()->detach();
        foreach ($request->input('cintas', []) as $i => $cinta){
        $ribbon->whiteRibbons()->attach($cinta,['nomenclatura'=>$ribbon->nomenclatura,
            'status'=>$ribbon->status, 
            'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
            'peso' => 0,
            'largo' => $request->input('largos.'. $i)]);
        }                                 
        
        $coilProduct = CoilProduct::where('coil_product_id', '=', $ribbon->id)->where('coil_product_type', '=', 'App\Models\Ribbon')->get()->first();
        $coilProduct->nomenclatura = $ribbon->nomenclatura;
        $coilProduct->status = $ribbon->status;
        $coilProduct->fAdquisicion = $ribbon->fechaInicioTrabajo; 
        $coilProduct->peso = $ribbon->peso;
        $coilProduct->save();


        return redirect()->route('ribbon.show', compact('ribbon'));
    }

    public function show(Ribbon $ribbon){
        //obtenemos la bobina relacionada al rollo
        $coil = $ribbon->coils()->get()->first();
        //obtenemos todas las bolsas relacionadas al rollo
        $bags =  Ribbon::find($ribbon->id);
        $bags = $bags->related()->get();
        $bag = $bags;
        $tiempo1 = new DateTime($ribbon->fechaInicioTrabajo . 'T' . $ribbon->horaInicioTrabajo);
        $tiempo2 = new DateTime($ribbon->fechaFinTrabajo . 'T' . $ribbon->horaFinTrabajo);
        $tiempod = $tiempo1->diff($tiempo2);
        $minutosLaborados = $tiempod->h * 60 + $tiempod->i;

        //mandamos cintilla en caso de que haya
        $cinta =  $ribbon->whiteRibbons()->get();

        return view('ribbons.show', compact('ribbon', 'bag', 'coil', 'cinta', 'minutosLaborados' ));
    }
   

    public function store(StoreRibbon $request)
    {
        //busca la bobina
        $coil = Coil::find($request->coilId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
        //if($coil->pesoBruto >= ($request->peso + $coil->pesoUtilizado)){
          
        $ribbon =  new ribbon();

        $ribbon->nomenclatura =  $request->nomenclatura;
        $ribbon->status =  $request->status;
        $ribbon->fechaInicioTrabajo =  $request->fechaInicioTrabajo;
        $ribbon->horaInicioTrabajo =  $request->horaInicioTrabajo;
        $ribbon->largo =  $request->largo;
        $ribbon->fechaFinTrabajo =  $request->fechaFinTrabajo;
        $ribbon->horaFinTrabajo =  $request->horaFinTrabajo;
        $ribbon->peso =  $request->peso;
        $ribbon->pesoUtilizado =  $request->pesoUtilizado;
        $ribbon->temperatura =  $request->temperatura;
        $ribbon->velocidad = $request->velocidad;
        //$ribbon->white_ribbon_id = $request->white_ribbon_id;
        $ribbon->observaciones = $request->observaciones;
        
        $ribbon->save();

        //si agregaron un rollo se crea relación
        foreach ($request->input('white_ribbon_ids', []) as $i => $white_ribbon_id){
            if($white_ribbon_id != 'N/A' )
                 $ribbon->whiteRibbons()->attach($white_ribbon_id,['nomenclatura'=>$ribbon->nomenclatura,
                                                                    'status'=>$ribbon->status, 
                                                                    'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                                                    'peso' => 0,
                                                                    'largo' => $request->input('largos.'. $i)]);
                                                            
        }
        
        //request->input('empleados') tiene los id's de los empleados
        $ribbon->employees()->attach($request->input('empleados'));        

        $addProduct = Ribbon::find($ribbon->id);
        $addProduct->coils()->attach($request->coilId, ['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => $ribbon->peso]);
        
        //actualiza la bobina
        $coil->pesoUtilizado = $request->peso + $coil->pesoUtilizado;
        /*if($coil->pesoUtilizado == $coil->pesoBruto){
            $coil->status = 'TERMINADA';                       
            $coil->pesoNeto = $coil->related()
                                    ->where('coil_product_type', '=', 'App\Models\Ribbon')
                                    ->orWhere('coil_product_type', '=', 'App\Models\WasteRibbon')
                                    ->sum('peso');
        }*/
        $coil->save();
        
        return redirect()->route('ribbon.show', compact('ribbon')); 
   /* }
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso del rollo sobrepasa el limite de peso de la bobina');
        }*/

    }

    public function reporteria(){
        $providers = Provider::all();
        
        $rollos = DB::select(
            'SELECT T1.provider_id as proveedor, T1.coil_type_id as medida, T1.cantidad, T2.white_ribbon_product_id as cintilla ' .
            'FROM ' .
                '(SELECT coils.provider_id, coils.coil_type_id, COUNT(coil_products.id) as cantidad, coil_products.coil_product_id ' .
                'FROM coils ' .
                'JOIN coil_products ' .
                'ON coils.id = coil_products.coil_id ' .
                'JOIN ribbons ' .
                'ON coil_products.coil_product_id = ribbons.id ' .
                "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE'" .
                'GROUP BY coils.coil_type_id, coils.provider_id ' .
                'ORDER BY coil_type_id) as T1 ' .
            'LEFT JOIN ' .
                '(SELECT white_ribbon_product_id ' .
                'FROM white_ribbon_products ' .
                "WHERE white_ribbon_products.white_ribbon_product_type = 'App\\\Models\\\Ribbon') as T2 " .
            'ON T1.coil_product_id = T2.white_ribbon_product_id'
        );
        //dd($rollos);
        $medidas = DB::select(
            'SELECT COUNT(ribbons.id) as total_de_piezas, SUM(ribbons.peso) as total_kg, coil_types.id, coil_types.alias ' . 
            'FROM coil_products ' . 
            'JOIN coils ' . 
            'ON coil_products.coil_id = coils.id ' .
            'JOIN coil_types ' .
            'ON coils.coil_type_id = coil_types.id ' .
            'JOIN ribbons ' .
            'ON coil_products.coil_product_id = ribbons.id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE' " .
            'GROUP BY coil_types.id, coil_types.alias ' .
            'ORDER BY coil_types.id'
        );
        
        $sumaDeTotales = DB::select(
            'SELECT COUNT(coil_products.id) as suma_total_piezas, SUM(ribbons.peso) as suma_total_peso ' .
            'FROM coil_products ' .
            'JOIN ribbons '.
            'ON ribbons.id = coil_product_id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE'"
        );
        $totalesDeProveedores = DB::select(
            'SELECT COUNT(coil_products.id) as cantidad ' .
            'FROM coils ' .
            'JOIN coil_products ' .
            'ON coils.id = coil_products.coil_id ' .
            'JOIN ribbons ' .
            'ON coil_products.coil_product_id = ribbons.id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE' " .
            'GROUP BY coils.provider_id ' .
            'ORDER BY coils.provider_id'
        );
        return view('ribbons.reporteria', compact('providers', 'medidas', 'rollos', 'totalesDeProveedores', 'sumaDeTotales'));
    }

    public function destroy(Ribbon $ribbon)
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

        //Eliminamos las relaciones del whiteRibbon con whiteCoil  
        foreach($ribbon->coils as $coil)
        {
            $coil->ribbons()->detach($ribbon);
        }

        //Eliminamos el registro de whiteRibbon desde su tabla 'whiteRibbons'
        $ribbon->delete();

        $nomenclatura = $ribbon->nomenclatura;
        $fArribo = $ribbon->fechaInicioTrabajo;
        $peso = $ribbon->peso;
        $type = 'App\Models\Ribbon';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('coilProduct.index')->with('eliminar', 'ribbon');
    }
    
    public function reporteriaPDF(){
        $providers = Provider::all();
        $rollos = DB::select(
            'SELECT T1.provider_id as proveedor, T1.coil_type_id as medida, T1.cantidad, T2.white_ribbon_product_id as cintilla ' .
            'FROM ' .
                '(SELECT coils.provider_id, coils.coil_type_id, COUNT(coil_products.id) as cantidad, coil_products.coil_product_id ' .
                'FROM coils ' .
                'JOIN coil_products ' .
                'ON coils.id = coil_products.coil_id ' .
                'JOIN ribbons ' .
                'ON coil_products.coil_product_id = ribbons.id ' .
                "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE'" .
                'GROUP BY coils.coil_type_id, coils.provider_id ' .
                'ORDER BY coil_type_id) as T1 ' .
            'LEFT JOIN ' .
                '(SELECT white_ribbon_product_id ' .
                'FROM white_ribbon_products ' .
                "WHERE white_ribbon_products.white_ribbon_product_type = 'App\\\Models\\\Ribbon') as T2 " .
            'ON T1.coil_product_id = T2.white_ribbon_product_id'
        );
        //dd($rollos);
        $medidas = DB::select(
            'SELECT COUNT(ribbons.id) as total_de_piezas, SUM(ribbons.peso) as total_kg, coil_types.id, coil_types.alias ' . 
            'FROM coil_products ' . 
            'JOIN coils ' . 
            'ON coil_products.coil_id = coils.id ' .
            'JOIN coil_types ' .
            'ON coils.coil_type_id = coil_types.id ' .
            'JOIN ribbons ' .
            'ON coil_products.coil_product_id = ribbons.id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE' " .
            'GROUP BY coil_types.id, coil_types.alias ' .
            'ORDER BY coil_types.id'
        );
        
        $sumaDeTotales = DB::select(
            'SELECT COUNT(coil_products.id) as suma_total_piezas, SUM(ribbons.peso) as suma_total_peso ' .
            'FROM coil_products ' .
            'JOIN ribbons '.
            'ON ribbons.id = coil_product_id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE'"
        );
        $totalesDeProveedores = DB::select(
            'SELECT COUNT(coil_products.id) as cantidad ' .
            'FROM coils ' .
            'JOIN coil_products ' .
            'ON coils.id = coil_products.coil_id ' .
            'JOIN ribbons ' .
            'ON coil_products.coil_product_id = ribbons.id ' .
            "WHERE coil_products.coil_product_type = 'App\\\Models\\\Ribbon' AND ribbons.status = 'DISPONIBLE' " .
            'GROUP BY coils.provider_id ' .
            'ORDER BY coils.provider_id'
        );
        return view('ribbons.reporteriaPDF', compact('providers', 'medidas', 'rollos', 'totalesDeProveedores', 'sumaDeTotales'));
    }
}
