<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProvider;

class ProviderController extends Controller
{

    public function __construct()
    {
    $this->middleware('can:provider.create')->only('create', 'store');
    $this->middleware('can:provider.edit')->only('edit', 'update');
    $this->middleware('can:provider.index')->only('index');
    $this->middleware('can:provider.destroy')->only('destroy');
    }

    public function index(Request $request)
    {        
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para este campo ya que se valida si es null
        //en su scope() dentro de Provider:Model
        $nombreEmpresa = $request->nombreEmpresa;

        $providers = Provider::leftjoin('contacts', 'providers.id', '=', 'contacts.provider_id')
            ->select('providers.id', 'providers.nombreEmpresa','providers.direccion', 'contacts.telefono')
            ->nombreEmpresa($nombreEmpresa)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        return $request->ajax() ? response()->json(view('providers.index', compact('providers', 'orderBy', 'nombreEmpresa', 'order'))->render())
                    : view('providers.index', compact('providers', 'orderBy', 'nombreEmpresa', 'order'));
    }

    public function create()
    {
        return view('providers.create');
    }
    
    public function store(StoreProvider $request)
    {
        if($request->has('providerForm'))
        {
            $provider = new Provider();

            $provider->nombreEmpresa =  $request->nombreEmpresa;
            $provider->paginaWeb     =  $request->paginaWeb;
            $provider->direccion     =  $request->direccion;
            $provider->estado        =  $request->estado;

            $provider->save();
        }
        else
        {
            $contact = new Contact();
            
            $contact->provider_id       =  $request->provider_id;
            $contact->telefono          =  $request->telefono;
            $contact->nombre            =  $request->nombre;
            $contact->correoElectronico =  $request->correoElectronico;
            $contact->apellidos         =  $request->apellidos;

            $contact->save();

            $provider = $contact->provider;
        }
        
        return redirect()->route('provider.show', $provider);
    }

    public function show(Provider $provider)
    {
        $contacts = $provider->contacts;
        $coils = $provider->coils;

        return view('providers.show', compact('provider', 'contacts', 'coils'));
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(StoreProvider $request, $id)//$id de Provider o Contact
    {
        if($request->has('providerForm'))
        {
            $provider = Provider::find($id);

            $provider->nombreEmpresa =  $request->nombreEmpresa;
            $provider->paginaWeb     =  $request->paginaWeb;
            $provider->direccion     =  $request->direccion;
            $provider->estado        =  $request->estado;

            $provider->save();
        }
        else
        {
            $contact = Contact::find($id);
            
            $contact->provider_id       =  $request->provider_id;
            $contact->telefono          =  $request->telefono;
            $contact->nombre            =  $request->nombre;
            $contact->correoElectronico =  $request->correoElectronico;
            $contact->apellidos         =  $request->apellidos;

            $contact->save();

            $provider = $contact->provider;
        }
        
        return redirect()->route('provider.show', $provider);
    }

    public function destroy(Request $request, $id)
    {
        if($request->has('providerForm'))
        {
            $provider = Provider::find($id);

            $provider->delete();

            return redirect()->route('provider.index')->with('eliminar', 'ok');
        }
        else
        {
            $contact = Contact::find($id);

            $provider = $contact->provider;

            $contact->delete();

            return redirect()->route('provider.show', $provider);
        }
    }
}
