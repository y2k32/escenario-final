<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Verifica que la ip del navegador sea la de la vpn
        $ipvpn_web3 = '192.168.10.3';
        // $ipaddress = gethostbynamel(gethostname());
        // $ip_actual = $ipaddress[1];
        // Aqui ya puedo checar el rol del usuario logeado y decidir
        // si hace el insert o no
        $rol_usurio = Auth::user()->rol;
        // 1 admin, 2 supervisor y 3 user normal
        if($rol_usurio == 1 /*&& $ip_actual == $ipvpn_web3*/){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'user_role' => ['required'],
                
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => intval($request->user_role),
                'status' => 'A'
            ]);
        }
        // if($rol_usurio == 2){

        // }
        // if($rol_usurio == 3){

        // }
        event(new Registered($user));

        //Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function allusers(Request $request){
        $users = User::all();
        return view('auth.allusers', compact('users'));
    }
    public function viewdata(Request $request, $id)
    { 
        $users = User::where('id', $id)->first();
        //dd($get_product);
        return view('auth.updateusers', compact('users'));
    }

    public function edit(Request $request)
    { 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user_role' => ['required'],
            'status' => ['required'],
        ]);
        $cambia_pass = $request->input('pregunta');

        $password_confirmation = $request->input('password_confirmation');
        $user = User::where('id', $request->input('id'))->first();
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        if($cambia_pass=='si' && $request->input('password') != ''){
            $user->password = Hash::make($request->input('password'));
        }
        $user->status=$request->input('status');
        $user->rol=$request->input('user_role');
        $user->save();
        return redirect()->route("show.user",[$user->id])->with("success","¡Usuario actualizado con éxito!");
    }
}
