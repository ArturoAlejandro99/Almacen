<?php

namespace Database\Seeders;

use App\Models\Bag;
use App\Models\BagMeasure;
use App\Models\Coil;
use App\Models\CoilReel;
use App\Models\CoilType;
use App\Models\Employee;
use App\Models\Provider;
use App\Models\Ribbon;
use App\Models\RibbonReel;
use App\Models\User;
use App\Models\WhiteCoil;
use App\Models\WhiteRibbon;
use App\Models\WhiteRibbonReel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    
    public function run()
    {

        $employee = new Employee();
        $employee->nombre       =   "ARTURO";
        $employee->fNacimiento  =   "1999-02-02";
        $employee->fIngreso     =   "2021-02-03";
        $employee->antiguedad   =   1;
        $employee->sueldoHora   =   18;
        $employee->telefono     =   3312805457;
        $employee->status       =   "ACTIVO";
        $employee->save();

        $coilType = new CoilType();
        $coilType->alias         =  "70";
        $coilType->anchoCm       =  1;
        $coilType->largoM        =  1;
        $coilType->densidad      =  1;
        $coilType->material      =  1;
        $coilType->calibre       =  1;
        $coilType->tipo          =  "CELOFAN";
        $coilType->observaciones =  NULL;
        $coilType->save();

        $bagMeasure = new BagMeasure();
        $bagMeasure->coil_type_id  =  1;
        $bagMeasure->ancho         =  3;
        $bagMeasure->largo         =  3;
        $bagMeasure->save();

        $coilType = new CoilType();
        $coilType->alias         =  "CENEFA";
        $coilType->anchoCm       =  1;
        $coilType->largoM        =  1;
        $coilType->densidad      =  1;
        $coilType->material      =  1;
        $coilType->calibre       =  1;
        $coilType->tipo          =  "CENEFA";
        $coilType->observaciones =  NULL;
        $coilType->save();

        $provider = new Provider();
        $provider->nombreEmpresa =  "Test";
        $provider->paginaWeb     =  "www.test.com.mx";
        $provider->direccion     =  "Av zoquipan 1410";
        $provider->estado        =  "Jalisco";
        $provider->save();

        $coil =  new Coil();
        $coil->provider_id = 1;
        $coil->coil_type_id = 1;
        $coil->nomenclatura = "MNB700903021";
        $coil->status =  "TERMINADA";
        $coil->fArribo =  "2021-03-09";
        $coil->pesoBruto =  54.8800;
        $coil->pesoNeto =  54.1500;
        $coil->observaciones =  NULL;
        $coil->diametroBobina =  1;
        $coil->diametroInterno =  1;
        $coil->diametroExterno =  1;
        $coil->largoM = 3709.9000;
        $coil->costo =  4247.3980;
        $coil->pesoUtilizado = 55.3800;
        $coil->save();

        $whiteCoil =  new WhiteCoil(); 
        $whiteCoil->provider_id = 1; 
        $whiteCoil->coil_type_id = 2;
        $whiteCoil->nomenclatura =  "MNB090302211";
        $whiteCoil->status =  "DISPONIBLE";
        $whiteCoil->fArribo =  "2021-03-09";
        $whiteCoil->peso =  5.1498;
        $whiteCoil->observaciones =  NULL;
        $whiteCoil->pesoUtilizado = 5.1498;
        $whiteCoil->costo = 346.9771;
        $whiteCoil->save();

        $whiteRibbon =  new WhiteRibbon();
        $whiteRibbon->nomenclatura =  "MNB09030221-1";
        $whiteRibbon->status = "DISPONIBLE";
        $whiteRibbon->fArribo =  "2021-03-09";
        $whiteRibbon->largo =  1774.9000;
        $whiteRibbon->peso =  2.4698;
        $whiteRibbon->Observaciones =  NULL;
        $whiteRibbon->pesoUtilizado = 1.0800;
        $whiteRibbon->costo = 166.41;
        $whiteRibbon->save();
        $whiteRibbon->whiteCoils()->attach(1, ['nomenclatura'=>$whiteRibbon->nomenclatura,
                                     'status'=>$whiteRibbon->status, 
                                     'fAdquisicion'=>$whiteRibbon->fArribo,
                                     'peso' => $whiteRibbon->peso]);

        $whiteRibbon =  new WhiteRibbon();
        $whiteRibbon->nomenclatura =  "MNB090320211-2";
        $whiteRibbon->status = "DISPONIBLE";
        $whiteRibbon->fArribo =  "2021-03-09";
        $whiteRibbon->largo =  1931;
        $whiteRibbon->peso =  2.6800;
        $whiteRibbon->Observaciones =  NULL;
        $whiteRibbon->pesoUtilizado = 1.0800;
        $whiteRibbon->costo = 2.6000;
        $whiteRibbon->save();
        $whiteRibbon->whiteCoils()->attach(1, ['nomenclatura'=>$whiteRibbon->nomenclatura,
                                     'status'=>$whiteRibbon->status, 
                                     'fAdquisicion'=>$whiteRibbon->fArribo,
                                     'peso' => $whiteRibbon->peso]);

        $whiteRibbonReel =  new WhiteRibbonReel();
        $whiteRibbonReel->nomenclatura =  "HUE-MNB090320211-1-1";
        $whiteRibbonReel->peso =  0.08;
        $whiteRibbonReel->observaciones =  NULL;
        $whiteRibbonReel->fechaAlta =  "2021-03-09";
        $whiteRibbonReel->status = "N/A";
        $whiteRibbonReel->save();
        $whiteRibbonReel->whiteRibbons()->attach(1, ['nomenclatura'=>$whiteRibbonReel->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$whiteRibbonReel->fechaAlta,
                                     'peso'=>$whiteRibbonReel->peso,
                                     'largo' => '0']);
        
        $whiteRibbonReel =  new WhiteRibbonReel();
        $whiteRibbonReel->nomenclatura =  "HUE-MNB090320211-2-1";
        $whiteRibbonReel->peso =  0.08;
        $whiteRibbonReel->observaciones =  NULL;
        $whiteRibbonReel->fechaAlta =  "2021-03-09";
        $whiteRibbonReel->status = "N/A";
        $whiteRibbonReel->save();
        $whiteRibbonReel->whiteRibbons()->attach(2, ['nomenclatura'=>$whiteRibbonReel->nomenclatura,
        'status'=>'N/A', 
        'fAdquisicion'=>$whiteRibbonReel->fechaAlta,
        'peso'=>$whiteRibbonReel->peso,
        'largo' => '0']);

        $ribbon =  new Ribbon();
        $ribbon->nomenclatura =  "MNB70090320211-1";
        $ribbon->status =  "TERMINADA";
        $ribbon->fechaInicioTrabajo =  "2021-03-07";
        $ribbon->horaInicioTrabajo =  "07:26:00";
        $ribbon->largo =  1202.3000;
        $ribbon->fechaFinTrabajo =  "2021-03-07";
        $ribbon->horaFinTrabajo =  "08:16:00";
        $ribbon->peso =  17.0400;
        $ribbon->pesoUtilizado =  27.7400;
        $ribbon->temperatura =  160;
        $ribbon->velocidad = 230;
        $ribbon->observaciones = NULL;
        $ribbon->save();
        $ribbon->employees()->attach(1); 
        $ribbon->coils()->attach(1, ['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => $ribbon->peso]);
        $ribbon->whiteRibbons()->attach(1,['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => 0,
                                     'largo' => 1202.3000]);

        $ribbon =  new Ribbon();
        $ribbon->nomenclatura =  "MNB70090320211-2";
        $ribbon->status =  "TERMINADA";
        $ribbon->fechaInicioTrabajo =  "2021-03-07";
        $ribbon->horaInicioTrabajo =  "07:26:00";
        $ribbon->largo =  1301.9000;
        $ribbon->fechaFinTrabajo =  "2021-03-07";
        $ribbon->horaFinTrabajo =  "08:16:00";
        $ribbon->peso =  18.5200;
        $ribbon->pesoUtilizado =  19.7500;
        $ribbon->temperatura =  160;
        $ribbon->velocidad = 230;
        $ribbon->observaciones = NULL;
        $ribbon->save();
        $ribbon->employees()->attach(1); 
        $ribbon->coils()->attach(1, ['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => $ribbon->peso]);
        $ribbon->whiteRibbons()->attach(1,['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => 0,
                                     'largo' => 572.6000]);
        $ribbon->whiteRibbons()->attach(2,['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => 0,
                                     'largo' => 729.3000]);

        $ribbon =  new Ribbon();
        $ribbon->nomenclatura =  "MNB70090320211-3";
        $ribbon->status =  "TERMINADA";
        $ribbon->fechaInicioTrabajo =  "2021-03-07";
        $ribbon->horaInicioTrabajo =  "07:26:00";
        $ribbon->largo =  1201.7000;
        $ribbon->fechaFinTrabajo =  "2021-03-07";
        $ribbon->horaFinTrabajo =  "08:16:00";
        $ribbon->peso =  18.1300;
        $ribbon->pesoUtilizado =  19.7900;
        $ribbon->temperatura =  160;
        $ribbon->velocidad = 230;
        $ribbon->observaciones = NULL;
        $ribbon->save();
        $ribbon->employees()->attach(1);
        $ribbon->whiteRibbons()->attach(2,['nomenclatura'=>$ribbon->nomenclatura,
                                     'status'=>$ribbon->status, 
                                     'fAdquisicion'=>$ribbon->fechaInicioTrabajo,
                                     'peso' => 0,
                                     'largo' => 1201.7000]);

        $coilReel =  new CoilReel();
        $coilReel->nomenclatura =  "HUE-MNB70090320211-1";
        $coilReel->peso =  0.7300;
        $coilReel->observaciones =  NULL;
        $coilReel->fechaAlta =  "2021-03-09";
        $coilReel->status = "N/A";
        $coilReel->save();
        $coilReel->coils()->attach(1, ['nomenclatura'=>$coilReel->nomenclatura,
                                     'status'=>$coilReel->status, 
                                     'fAdquisicion'=>$coilReel->fechaAlta,
                                     'peso' => $coilReel->peso]);

        $ribbonReel =  new RibbonReel();
        $ribbonReel->nomenclatura =  "HUE-MNB70090320211-1-1";
        $ribbonReel->peso =  0.7000;
        $ribbonReel->observaciones =  NULL;
        $ribbonReel->fechaAlta =  "2021-03-09";
        $ribbonReel->status = "N/A";
        $ribbonReel->save();
        $ribbonReel->ribbons()->attach(1, ['nomenclatura'=>$ribbonReel->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$ribbonReel->fechaAlta,
                                     'peso' =>$ribbonReel->peso]);

        $ribbonReel =  new RibbonReel();
        $ribbonReel->nomenclatura =  "HUE-MNB70090320211-2-1";
        $ribbonReel->peso =  0.7000;
        $ribbonReel->observaciones =  NULL;
        $ribbonReel->fechaAlta =  "2021-03-09";
        $ribbonReel->status = "N/A";
        $ribbonReel->save();
        $ribbonReel->ribbons()->attach(2, ['nomenclatura'=>$ribbonReel->nomenclatura,
                                     'status'=>'N/A', 
                                     'fAdquisicion'=>$ribbonReel->fechaAlta,
                                     'peso' =>$ribbonReel->peso]);

        $bag = new Bag();
        $bag->bag_measure_id     = 1;
        $bag->fechaInicioTrabajo = "2021-03-09";
        $bag->fechaFinTrabajo    = "2021-03-09";
        $bag->horaInicioTrabajo  = "08:32:00";
        $bag->horaFinTrabajo     = "09:17:00";
        $bag->nomenclatura       = "MNB700903021-1-1";  
        $bag->clienteStock       = "CLIENTE";
        $bag->peso               = 17.0400;
        $bag->tipoUnidad         = "MILLAR";
        $bag->cantidad           = 4;
        $bag->status             = "TERMINADA";
        $bag->temperatura        = 160;
        $bag->velocidad          = 220;
        $bag->observaciones      = NULL;
        $bag->save();
        $bag->employees()->attach(1); 
        $bag->ribbons()->attach(1, ['nomenclatura'=>$bag->nomenclatura,
                                        'status'=>$bag->status, 
                                        'fAdquisicion'=>$bag->fechaInicioTrabajo,
                                        'peso'=>$bag->peso,
                                        'cantidad'=>$bag->cantidad,
                                        'unidad'=>$bag->tipoUnidad,
                                        'medidaBolsa'=> round($bag->bagMeasure->largo) .' x '. round($bag->bagMeasure->ancho) . ($ribbon->whiteRibbons()->get()->isEmpty()? '' : ' C/P')]);

        $bag = new Bag();
        $bag->bag_measure_id     = 1;
        $bag->fechaInicioTrabajo = "2021-03-09";
        $bag->fechaFinTrabajo    = "2021-03-09";
        $bag->horaInicioTrabajo  = "08:32:00";
        $bag->horaFinTrabajo     = "09:17:00";
        $bag->nomenclatura       = "MNB700903021-2-1";  
        $bag->clienteStock       = "CLIENTE";
        $bag->peso               = 18.3100;
        $bag->tipoUnidad         = "MILLAR";
        $bag->cantidad           = 4.3;
        $bag->status             = "TERMINADA";
        $bag->temperatura        = 160;
        $bag->velocidad          = 220;
        $bag->observaciones      = NULL;
        $bag->save();
        $bag->employees()->attach(1); 
        $bag->ribbons()->attach(2, ['nomenclatura'=>$bag->nomenclatura,
                                        'status'=>$bag->status, 
                                        'fAdquisicion'=>$bag->fechaInicioTrabajo,
                                        'peso'=>$bag->peso,
                                        'cantidad'=>$bag->cantidad,
                                        'unidad'=>$bag->tipoUnidad,
                                        'medidaBolsa'=>$bag->bagMeasure->largo .' x '. $bag->bagMeasure->ancho . ($ribbon->whiteRibbons()->get()->isEmpty()? '' : ' C/P')]);

        $bag = new Bag();
        $bag->bag_measure_id     = 1;
        $bag->fechaInicioTrabajo = "2021-03-09";
        $bag->fechaFinTrabajo    = "2021-03-09";
        $bag->horaInicioTrabajo  = "08:32:00";
        $bag->horaFinTrabajo     = "09:17:00";
        $bag->nomenclatura       = "MNB70090320211-3-1";  
        $bag->clienteStock       = "CLIENTE";
        $bag->peso               = 16.6100;
        $bag->tipoUnidad         = "MILLAR";
        $bag->cantidad           = 3.9;
        $bag->status             = "TERMINADA";
        $bag->temperatura        = 160;
        $bag->velocidad          = 220;
        $bag->observaciones      = NULL;
        $bag->save();
        $bag->employees()->attach(1); 
        $bag->ribbons()->attach(3, ['nomenclatura'=>$bag->nomenclatura,
                                        'status'=>$bag->status, 
                                        'fAdquisicion'=>$bag->fechaInicioTrabajo,
                                        'peso'=>$bag->peso,
                                        'cantidad'=>$bag->cantidad,
                                        'unidad'=>$bag->tipoUnidad,
                                        'medidaBolsa'=>$bag->bagMeasure->largo .' x '. $bag->bagMeasure->ancho . ($ribbon->whiteRibbons()->get()->isEmpty()? '' : ' C/P')]);
        

        $this->call(RoleSeeder::class);

        User::create([
            'name' => 'MINABI',
            'email' => 'bodega@minabiplast.com',
            'password' => Hash::make('minabi123')
        ])->assignRole('Admin');
    }
}
