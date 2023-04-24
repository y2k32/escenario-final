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
        $ipvpn = env('IP_VPN');
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
        }else{
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
}
