<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Salida;
use App\Models\UserCode;

class SalidaController extends Controller
{
    //
    public function allsalidas(Request $request){
        $salidas = Salida::all();
        return view('salidas.allsalidas', compact('salidas'));
    }
    public function index(Request $request)
    { 
        $products = Producto::all();
        return view('salidas.salidas', compact('products'));
    }
    public function store(Request $request)
    { 
        $new_entrada = new Salida();
        $new_entrada->Produc_id=$request->input('sl_product');
        $new_entrada->Cantidad=$request->input('cantidad');
        $new_entrada->Total=$request->input('total');
        $new_entrada->save();
        return redirect()->route("salidas")->with("success","¡Salida generada con éxito!");
    }
    public function viewdata(Request $request, $id)
    { 
        $salida = Salida::where('id', $id)->first();
        $products = Producto::all();
        //dd($get_product);
        return view('salidas.updatesalida', compact('salida','products'));
    }
    public function edit(Request $request)
    { 
        $salida = Salida::where('id', $request->input('id'))->first();
        $salida->Produc_id=$request->input('sl_product');
        $salida->Cantidad=$request->input('cantidad');
        $salida->Total=$request->input('total');
        if(Auth::user()->rol == 3){
            $codigo_v = $request->input('codigo_v');
            $has_code_v = UserCode::where('code', "!=","")
            ->get();
            //dd($codigo_v,$has_code_v); aqui si llego
            if(count($has_code_v) > 0){
                foreach ($has_code_v as $codes) {
                    //dd($codes); aqui si llego
                    if(Hash::check($codigo_v, $codes->code)){
                        $up_code = UserCode::find($codes->id);
                        //dd($up_code);
                        $up_code->code = "";
                        $up_code->encrypt_code = "";
                        $up_code->save();
                        $salida->save();
                        return redirect()->route("show.salida",[$salida->id])->with("success","¡Salida actualizada con éxito!");
                    }
                }
            }
            return redirect()->route("show.salida",[$salida->id])->with("error","¡Salida no actualizada, No tienes autorización!");
        }else{
            $salida->save();
            return redirect()->route("show.salida",[$salida->id])->with("success","¡Salida actualizada con éxito!");
        }
    }
    public function delete(Request $request)
    { 

    }
}
