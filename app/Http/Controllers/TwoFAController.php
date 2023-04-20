<?php

namespace App\Http\Controllers;

use App\Events\QrEvent;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
//use Illuminate\Support\Facades\Auth as FacadesAuth;

class TwoFAController extends Controller
{


    public function store(Request $request)
    {   
        // Necesito es codigo hasheado y encriptadado
        // para poderlo desencriptar y mandarlo a la vista
        $encypt_key = env('CRYPT_KEY');
        $codigoLogin = strval(mt_rand(100000, 999999));
        $codigoAPP = strval(mt_rand(100000, 999999));
        $has_code = [];
        $get_id = 0;
        $get_email = "";
        // $step_two Esta variable dira cual es el siguiente paso en el login del usuario
        $step_two = "";
        // Aqui se debe preguntar el rol del usuario
        // a fin de saber cuantos metodos de autenticacion debe
        // pasar
        $has_code = UserCode::where('user_id', Auth::user()->id)
            ->where('code', "!=","")
            ->get();
        
        if(Auth::user()->rol == 1 || Auth::user()->rol == 2){
            if(count($has_code)==0){
                $code_gen = new UserCode();
                //$code_gen->user_id = Auth::user()->id;
                $code_gen->user_id = Auth::user()->id;
                $code_gen->code = Hash::make($codigoLogin);
                $code_gen->encrypt_code = Crypt::encryptString($codigoLogin, $encypt_key);
                $code_gen->appcode = Hash::make($codigoAPP);
                $code_gen->encrypt_appcode = Crypt::encryptString($codigoAPP, $encypt_key);
                $code_gen->save();
        
                $signed_url = URL::temporarySignedRoute(
                    'show_code', now()->addMinutes(15), Auth::user()->id
                );
                $mail= new SendMail($signed_url);
                //dd(Auth::guard('admin')->user()->email); estos si regresa algo
                //dump($get_email);

                //$get_email = debe ser un email valido y existente o dara error;
                /*Auth::user()->email*/
                $get_email = Auth::user()->email;
                //dd($get_email);
                Mail::to($get_email)
                    ->send($mail);
                //dd($get_email);
                return view('codes.checkcode');
            }
            
        }else{
            Session::put('code', $codigoLogin);
            return redirect('dashboard');
        }
        //return view('codes.checkcode');
    }
    public function show(Request $request)
    {   
        $step_two = "";
        $has_code = [];
        $get_id = 0;
        $get_email = "";
        // En este metodo se desencripta el codigo web
        // y una ves desencriptado se retorna su valor en
        // texto plano junto con la vista codes.code
        try {
            $encypt_key = env('CRYPT_KEY');
            $code = UserCode::where('user_id',  Auth::user()->id)
                ->where('code', '!=',"")
                ->first();
            return view('codes.code',['decrypt_code'=>Crypt::decryptString($code->encrypt_code, $encypt_key)]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage()
            ], 400); 
        }
    }

    public function showQr(Request $request)
    {   
        $step_two = "";
        $has_code = [];
        $get_id = 0;
        $get_email = "";
        // En este metodo se desencripta el codigo web
        // y una ves desencriptado se retorna su valor en
        // texto plano junto con la vista codes.code
        try {
            $encypt_key = env('CRYPT_KEY');
            $code = UserCode::where('user_id',  Auth::user()->id)
                ->where('code', '!=',"")->where('rol','=',1)
                ->first();
            //return view('codes.code',['decrypt_code'=>Crypt::decryptString($code->encrypt_code, $encypt_key)]);
            return view('codes.code',['decrypt_code'=>Crypt::decryptString($code->encrypt_code, $encypt_key)]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage()
            ], 400); 
        }
    }

    public function ckeckCodeWebDos(Request $request)
    {
        $encypt_key = env('CRYPT_KEY');
        $login_code = $request->input('login_code');
        $user_codes = UserCode::where('user_id', Auth::user()->id)
            ->where('code', "!=", "")
            ->get();
        $application_code = "";
        //dd($user_codes); si tiene datos
        //dd(Auth::user());
        foreach ($user_codes as $codes) {
            // dd($codes->code, $login_code);
            if(Hash::check($login_code, $codes->code)){
                $up_code = UserCode::find($codes->id);
                //dd($up_code);
                $up_code->code = "";
                $up_code->encrypt_code = "";
                $get_appcodeapp = $up_code->encrypt_appcode;
                $up_code->save();
                if(Auth::user()->rol == 1){
                    //return view('codes.qrcode');
                    // $signed_url = URL::temporarySignedRoute(
                    //     'verificateQr', now()->addMinutes(15),[ Auth::user()->id, 'application_code'=>Crypt::decryptString($get_appcodeapp, $encypt_key)]
                    // );
                    $signed_route = URL::signedRoute(
                        'verifying_qr'
                    );
                    //return view('codes.qrcode',['qr_codeapp'=>Crypt::decryptString($up_code->encrypt_appcode, $encypt_key)]);
                    return view('codes.qrcode',['qr_codeapp'=>QrCode::size(300)->generate($signed_route), 'url'=>$signed_route, 'user'=>$request->user()->email]);
                }elseif(Auth::user()->rol == 2){
                    Session::put('code', $codes->code);
                    return redirect('dashboard');
                }
            }
        }
        return view('codes.checkcode');
    }

    public function verifying_qr(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where("email", $email)->get();
        //dd($user);
        //return $user;
        event(new QrEvent($user));
    }
    public function verificated_qr()
    {
        Session::put('code', 20000);
        Session::put('qr_code', true);
        return redirect('dashboard');
    }

    public function ckeckCodeWeb(Request $request)
    {
        //dd(Auth::user());
        $encypt_key = env('CRYPT_KEY');
        $login_code = $request->input('login_code');
        $user_codes = UserCode::where('user_id', Auth::user()->id)
            ->where('code', "!=", "")
            ->get();
        foreach ($user_codes as $codes) {
            if(Hash::check($login_code, $codes->login_code)){
                $up_code = User::find($codes->id);
                $up_code->code = "";
                $up_code->encrypt_code = "";
                $up_code->save();
                // if(Auth::user()->rol == 1){
                //     dd(Auth::user()->name, Auth::user()->rol);
                //     return view('codes.qrcode',['qr_code'=>Crypt::decryptString($up_code->encrypt_appcode, $encypt_key)]);
                // }
                //elseif(Auth::user()->rol == 2){
                    Session::put('code', $codes->login_code);
                    return redirect('dashboard');
                //}
            }
        }
        return view('codes.checkcode');
    }
    
    public function ckeckCodeApp(Request $request)
    {
        $has_code = [];
        $get_id = 0;
        $get_email = "";
        $encypt_key = env('CRYPT_KEY');
        $app_code = $request->input('application_code');
        $user_codes = UserCode::where('code', "!=", "")->get();
        foreach ($user_codes as $codes) {
            if(Hash::check($app_code, $codes->appcode)){
                return response()->json([
                    'response'=> Crypt::decryptString($codes->encrypt_appcode, $encypt_key)
                ],201);
            }
        }
        return response()->json([
            'response'=> "invalid Code"
        ], 406);
    }

    public function ckeckCodeApp2(Request $request)
    {
        $has_code = [];
        $get_id = 0;
        $get_email = "";
        $encypt_key = env('CRYPT_KEY');
        $app_code = $request->header('application_code');
        //dd($app_code);
        $user_codes = UserCode::where('appcode', "!=", "")->where('rol','=',1)->get();
        //dd($user_codes);
        foreach ($user_codes as $codes) {
            if(Hash::check($app_code, $codes->appcode)){
                return response()->json([
                    'response'=> Crypt::decryptString($codes->encrypt_appcode, $encypt_key)
                ],201);
            }
        }
        return response()->json([
            'response'=> "invalid Code"
        ], 406);
    }
    // Metodos movil app
    public function loginapp(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where("email", $email)->first();
        if(Hash::check($password, $user->password)){
            return response()->json([
                'response'=> "yes"
            ],201);
        }
        return response()->json([
            'response'=> "Error Login"
        ], 406);
    }
}
