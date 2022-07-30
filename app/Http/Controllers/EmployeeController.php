<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployee;

class EmployeeController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:employee.create')->only('create', 'store');
    $this->middleware('can:employee.edit')->only('edit', 'update');
    $this->middleware('can:employee.index')->only('index');
    $this->middleware('can:employee.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para estos campo ya que se valida si es null
        //en sus scope()
        $nombre = $request->nombre;
        $status = $request->status;

        $employees = Employee::nombre($nombre)
            ->status($status)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        $allStatus = Employee::select('status')
            ->distinct()
            ->get();
        
        return $request->ajax() ? response()->json(view('employees.index', compact('employees', 'allStatus', 'orderBy', 'nombre', 'order', 'status'))->render())
                    : view('employees.index', compact('employees', 'allStatus', 'orderBy', 'nombre', 'order', 'status'));
    }

    public function create()
    {
        return view('employees.create');
    }
    
    public function store(StoreEmployee $request)
    {
        $employee = new Employee();

        $employee->nombre       =   $request->nombre;
        $employee->fNacimiento  =   $request->fNacimiento;
        $employee->fIngreso     =   $request->fIngreso;
        $employee->antiguedad   =   $request->antiguedad;
        $employee->sueldoHora   =   $request->sueldoHora;
        $employee->telefono     =   $request->telefono;
        $employee->status       =   $request->status;
        
        $employee->save();
        
        return redirect()->route('employee.show', $employee);
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(StoreEmployee $request, Employee $employee)
    {
        $employee->nombre       =   $request->nombre;
        $employee->fNacimiento  =   $request->fNacimiento;
        $employee->fIngreso     =   $request->fIngreso;
        $employee->antiguedad   =   $request->antiguedad;
        $employee->sueldoHora   =   $request->sueldoHora;
        $employee->telefono     =   $request->telefono;
        $employee->status       =   $request->status;

        $employee->save();
        
        return redirect()->route('employee.show', $employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employee.index')->with('eliminar', 'ok');
    }
}
