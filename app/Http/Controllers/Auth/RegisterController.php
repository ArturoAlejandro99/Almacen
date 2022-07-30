<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        //$this->middleware('guest');
        echo 'hola';
    }
*/
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function __construct()
    {
    $this->middleware('can:user.create')->only('store', 'create');
    $this->middleware('can:user.edit')->only('edit', 'update');
    $this->middleware('can:user.destroy')->only('destroy');
    $this->middleware('can:user.index')->only('index');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

     public function create(){
        
        $roles = Role::all();
        return view('users.register', compact('roles'));
     }

    protected function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->sync($request->role_id);

        return redirect()->route('user.index');
    }

    public function index(Request $request){
        //Valido que los campos existan sino les doy un valor por defecto
        $orderBy = $request->orderBy ?? 'id';
        $order = $request->order ?? 'ASC';

        //No es necesario der un valor por defecto para este campo ya que se valida si es null
        //en su scope() dentro de Provider:Model
        $name = $request->name;

        $users = User::name($name)
            ->orderBy($orderBy, $order)
            ->paginate(10);

        return $request->ajax() ? response()->json(view('users.index', compact('users', 'orderBy', 'name', 'order'))->render())
                    : view('users.index', compact('users', 'orderBy', 'name', 'order'));
    }

    public function edit(User $user){       
        $roles = Role::all();
        $key = $user->roles()->get()->first()->id;
        return view('users.edit', compact('roles', 'user', 'key'));
    }

    protected function update(Request $request)
    {
        $user = User::find($request->id);
        User::destroy($user->id);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->roles()->sync($request->role_id);

        return redirect()->route('user.index');
    }

    public function destroy($id){
        $user = User::find($id);
        User::destroy($user->id);
        return redirect()->route('user.index')->with('eliminar', 'ok');
    }
}
