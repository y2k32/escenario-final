<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCode;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CodigoController extends Controller
{
    // Aqui se generan los codigos de autorizacion
    // para que el usuario de bajos privilegios
    // pueda editar los datos
    public function generate(Request $request)
    {
        $encypt_key = env('CRYPT_KEY');
        $codigoauto = strval(mt_rand(100000, 999999));
        // A qui se genera el codigo, pero ocupamos el id del usuario que lo generara
        // pendiente ver con keneth los sockets
        $has_code = UserCode::where('user_id', Auth::user()->id)
            ->get();
        $ipvpn = "192.168.100.2:8000";
        $host = $_SERVER["HTTP_HOST"];
        if ($host == $ipvpn) {
            if (Auth::user()->rol == 1 || Auth::user()->rol == 2) {
                if (count($has_code) == 0) {
                    $code_gen = new UserCode();
                    //$code_gen->user_id = Auth::user()->id;
                    $code_gen->user_id = Auth::user()->id;
                    $code_gen->rol = Auth::user()->rol;
                    $code_gen->code = Hash::make($codigoauto);
                    $code_gen->encrypt_code = Crypt::encryptString($codigoauto, $encypt_key);
                    // $code_gen->appcode = Hash::make($codigoAPP);
                    // $code_gen->encrypt_appcode = Crypt::encryptString($codigoAPP, $encypt_key);
                    $code_gen->save();
                    $signed_url = URL::temporarySignedRoute(
                        'show_code_v',
                        now()->addMinutes(15),
                        Auth::user()->id
                    );
                    // return URL::signedRoute('protected-route', ['user' => 1]);
                    // return view('codes.checkcode');
                    return redirect($signed_url); //URL::temporarySignedRoute('show_code_v', now()->addMinutes(15), Auth::user()->id);
                } else {
                    $upt_code = UserCode::where("user_id", Auth::user()->id)->first();
                    $upt_code->code = Hash::make($codigoauto);
                    $upt_code->encrypt_code = Crypt::encryptString($codigoauto, $encypt_key);
                    $upt_code->rol = Auth::user()->rol;
                    // $code_gen->appcode = Hash::make($codigoAPP);
                    // $code_gen->encrypt_appcode = Crypt::encryptString($codigoAPP, $encypt_key);
                    $upt_code->save();
                    $signed_url = URL::temporarySignedRoute(
                        'show_code_v',
                        now()->addMinutes(15),
                        Auth::user()->id
                    );
                    return redirect($signed_url);
                }
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'Credenciales invalidas para generar códigos de autorización.');
        }
        return redirect()->route('dashboard')->with('error', 'Ha ocurrido un error al generar códigos de autorización.');
    }
    public function show(Request $request)
    {
        if (Auth::user()->rol == 1 || Auth::user()->rol == 2) {
            try {
                $encypt_key = env('CRYPT_KEY');
                $code = UserCode::where('user_id',  Auth::user()->id)
                    ->where('code', '!=', "")
                    ->first();
                return view('codes.codeauto', ['decrypt_code' => Crypt::decryptString($code->encrypt_code, $encypt_key)]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => $th->getMessage()
                ], 400);
            }
        }
    }
    public function CodeEmail(Request $request)
    {
        $users = User::where("status", "!=", "B")->get();
        if (!is_null($users)) {
            $encypt_key = env('CRYPT_KEY');
            $codigoauto = strval(mt_rand(100000, 999999));
            // A qui se genera el codigo, pero ocupamos el id del usuario que lo generara
            // pendiente ver con keneth los sockets
            $has_code = UserCode::where('user_id', Auth::user()->id)
                ->get();
            $ipvpn = "192.168.100.2:8000";
            $host = $_SERVER["HTTP_HOST"];
            if ($host == $ipvpn) {
                if (Auth::user()->rol == 1 || Auth::user()->rol == 2) {
                    if (count($has_code) == 0) {
                        $code_gen = new UserCode();
                        //$code_gen->user_id = Auth::user()->id;
                        $code_gen->user_id = Auth::user()->id;
                        $code_gen->rol = Auth::user()->rol;
                        $code_gen->code = Hash::make($codigoauto);
                        $code_gen->encrypt_code = Crypt::encryptString($codigoauto, $encypt_key);
                        $code_gen->save();
                    } else {
                        $upt_code = UserCode::where("user_id", Auth::user()->id)->first();
                        $upt_code->code = Hash::make($codigoauto);
                        $upt_code->encrypt_code = Crypt::encryptString($codigoauto, $encypt_key);
                        $upt_code->rol = Auth::user()->rol;
                        $upt_code->save();
                    }
                    return view('codes.sendcode',["users" => $users, "codigo"=>$codigoauto]);
                }
            } else {
                return redirect()->route('dashboard')->with('error', 'Credenciales invalidas para generar códigos de autorización.');
            }
            //return redirect()->route('autorized.code')->with('error', 'Ha ocurrido un error al generar códigos de autorización.');
        } else {
            return redirect()->route('dashboard')->with('error', 'No se encontraron usuarios, favar de contactar al administrador.');
        }
    }
    public function sendCodeEmail(Request $request){
        $users = User::where("status", "!=", "B")
            	->where("id",$request->input("sl_user"))->first();
        if (!is_null($users)) {
            $codigo =$request->input('codigo');
            // $signed_url = URL::temporarySignedRoute(
            //     'show_code_v',
            //     now()->addMinutes(15)
            // );
            $mail = new SendMail($codigo);
            $get_email = $users->email;
            Mail::to($get_email)->send($mail);
            return redirect()->route('dashboard')->with('success', 'El código de autorización fue enviado al email seleccionado.');
        }else{
            return redirect()->route('dashboard')->with('error', 'El código de autorización no fue enviado al email seleccionado.');
        }
    }
}
