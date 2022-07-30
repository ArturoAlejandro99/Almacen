<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:rol.create')->only('create', 'store');
    $this->middleware('can:rol.edit')->only('edit', 'update');
    $this->middleware('can:rol.destroy')->only('destroy');
    $this->middleware('can:rol.index')->only('index');
    }

    public function index(){
        $roles = Role::all();
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create(){
        $permisos = Permission::all();
        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request){
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permisos'));
        Artisan::call('cache:clear');
        return redirect()->route('rol.index');
    }

    public function edit(Role $rol)
    {
        $permisos = $rol->permissions()->select('description')->get()->makeHidden('pivot');
        $arreglo = [];
        //$permisos =  Permission::all();
        foreach($permisos as $permiso)
        array_push($arreglo, $permiso->id);

        $permisos = Permission::all();

        return view('roles.edit', compact('rol', 'arreglo', 'permisos'));
        
    }

    public function show(Role $rol)
    {
        $permisos = $rol->permissions()->get();

        return view('roles.show', compact('permisos', 'rol'));
        
    }

    public function update(Request $request){
        $rol = Role::findById($request->id);
        $rol->permissions()->sync($request->input('permisos'));
        Artisan::call('cache:clear');
        return redirect()->route('rol.show', compact('rol'));
    }

    public function destroy(Role $rol)
    {
        $rol->delete();

        return redirect()->route('rol.index')->with('eliminar', 'ok');
    }
   
}
