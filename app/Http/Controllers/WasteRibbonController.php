<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWasteRibbon;
use App\Models\WasteRibbon;
use App\Models\Coil;
use App\Models\CoilProduct;
use App\Models\Employee;
use Illuminate\Http\Request;

class WasteRibbonController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:wasteRibbon.create')->only('createProduct', 'store');
    $this->middleware('can:wasteRibbon.edit')->only('edit', 'update');
    $this->middleware('can:wasteRibbon.destroy')->only('destroy');
    }

    public function index(){
        $wasteRibbons = WasteRibbon::select('nomenclatura', 'fechaInicioTrabajo' )->get();
        $wasteRibbons = WasteRibbon::paginate(10);

        return view('wasteRibbons.index', compact('wasteRibbons'));
    }

    public function create(){
        return view('wasteRibbons.create');
    }

    //funcion para crear relaciones con bobina
    public function createProduct(Request $request){
        $coil = Coil::find($request->coil);
        $employees = Employee::all();

        $nomenclatura = 'MER-' . $coil->nomenclatura . '-' . ($coil->ribbons()->count()+1);
        return view('wasteRibbons.create', ['coilId' => $request->coil, 'nomenclatura' => $nomenclatura, 'employees' => $employees]);
    }

    public function edit(WasteRibbon $wasteRibbon){
        $employees = Employee::all(); 

        return view('wasteRibbons.edit', compact('wasteRibbon', 'employees'));
    }

    public function update(StoreWasteRibbon $request, WasteRibbon $wasteRibbon){
        $wasteRibbon->nomenclatura =  $request->nomenclatura;
        $wasteRibbon->fechaInicioTrabajo =  $request->fechaInicioTrabajo;
        $wasteRibbon->fechaFinTrabajo =  $request->fechaFinTrabajo;
        $wasteRibbon->horaInicioTrabajo =  $request->horaInicioTrabajo;
        $wasteRibbon->horaFinTrabajo =  $request->horaFinTrabajo;
        $wasteRibbon->peso =  $request->peso;
        $wasteRibbon->observaciones =  $request->observaciones;
        $wasteRibbon->largo =  $request->largo;
        $wasteRibbon->temperatura =  $request->temperatura;
        $wasteRibbon->velocidad =  $request->velocidad;

        $wasteRibbon->save();

        $coilProduct = CoilProduct::where('coil_product_id', '=', $wasteRibbon->id)->where('coil_product_type', '=', 'App\Models\WasteRibbon')->get()->first();
        $coilProduct->nomenclatura = $wasteRibbon->nomenclatura;
        $coilProduct->status = $wasteRibbon->status;
        $coilProduct->fAdquisicion = $wasteRibbon->fechaAlta; 
        $coilProduct->peso = $wasteRibbon->peso;
        $coilProduct->save();

        //request->input('empleados') tiene los id's de los empleados
        $wasteRibbon->employees()->sync($request->input('empleados')); 

        return redirect()->route('wasteRibbon.show', compact('wasteRibbon'));
    }

    public function show(WasteRibbon $wasteRibbon){
        //obtenemos bobina relacionada
        $coil = $wasteRibbon->coils()->get()->first();

        return view('wasteRibbons.show', compact('wasteRibbon', 'coil'));
    }

    public function store(StoreWasteRibbon $request)
    {
        //busca la bobina
        $coil = Coil::find($request->coilId);
        //si el pesoutilizado mas el peso de rollo es menor o igual al peso de la bobina entonces crear el rollo
        //if($coil->pesoBruto >= ($request->peso + $coil->pesoUtilizado)){

        $wasteRibbon =  new WasteRibbon();

        $wasteRibbon->nomenclatura =  $request->nomenclatura;
        $wasteRibbon->fechaInicioTrabajo =  $request->fechaInicioTrabajo;
        $wasteRibbon->fechaFinTrabajo =  $request->fechaFinTrabajo;
        $wasteRibbon->horaInicioTrabajo =  $request->horaInicioTrabajo;
        $wasteRibbon->horaFinTrabajo =  $request->horaFinTrabajo;
        $wasteRibbon->peso =  $request->peso;
        $wasteRibbon->observaciones =  $request->observaciones;
        $wasteRibbon->largo =  $request->largo;
        $wasteRibbon->temperatura =  $request->temperatura;
        $wasteRibbon->velocidad =  $request->velocidad;
        $wasteRibbon->status = 'N/A';

        $wasteRibbon->save();
        
        //request->input('empleados') tiene los id's de los empleados, verificamos si
        //hay empleados antes de agregar
        $empleados = $request->input('empleados');
        if($empleados[0] != null) $wasteRibbon->employees()->attach($empleados);    

        $addProduct = WasteRibbon::find($wasteRibbon->id);
        $addProduct->coils()->attach($request->coilId, ['nomenclatura'=>$wasteRibbon->nomenclatura,
                                     'status'=>"N/A", 
                                     'fAdquisicion'=>$wasteRibbon->fechaInicioTrabajo,
                                     'peso' =>$wasteRibbon->peso]);
        
        //actualiza la bobina
        $coil->pesoUtilizado = $request->peso + $coil->pesoUtilizado;
       /*if($coil->pesoUtilizado == $coil->pesoBruto){
            $coil->status = 'TERMINADA';                       
            $coil->pesoNeto = $coil->related()
                                    ->where('coil_product_type', '=', 'App\Models\Ribbon')
                                    ->orWhere('coil_product_type', '=', 'App\Models\WasteRibbon')
                                    ->sum('peso');
        }    */                  
        $coil->save();
        
        return redirect()->route('wasteRibbon.show', compact('wasteRibbon'));  
        /*}
        //en caso de que no pase el if regresamos el formulario con los valores y el mensaje de error
        else{
            return redirect()->back()->withInput($request->all())->withErrors('El peso de la merma sobrepasa el limite de peso de la bobina');
        }*/
    }

    public function destroy(WasteRibbon $wasteRibbon)
    {
        //Eliminamos las relaciones del wasteRibbon con coil  
        foreach($wasteRibbon->coils as $coil)
        {
            $coil->wasteRibbons()->detach($wasteRibbon);
        }

        //Eliminamos el registro de wasteRibbon desde su tabla 'wasteRibbons'
        $wasteRibbon->delete();

        $nomenclatura = $wasteRibbon->nomenclatura;
        $fArribo = $wasteRibbon->fechaInicioTrabajo;
        $peso = $wasteRibbon->peso;
        $type = 'App\Models\WasteRibbon';

        return redirect()->route('destroy.store', compact('nomenclatura', 'fArribo', 'peso', 'type'));

        //return redirect()->route('coilProduct.index')->with('eliminar', 'wasteRibbon');
    }
}
