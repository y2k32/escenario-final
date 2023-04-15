<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Entrada;
use App\Models\Producto;
use App\Models\UserCode;

class EntradaController extends Controller
{
    //
    public function allentradas(Request $request){
        $entradas = Entrada::all();
        return view('entradas.allentradas', compact('entradas'));
    }
    public function index(Request $request)
    { 
        $products = Producto::all();
        return view('entradas.entradas', compact('products'));
    }
    public function store(Request $request)
    { 
        $new_entrada = new Entrada();
        $new_entrada->Produc_id=$request->input('sl_product');
        $new_entrada->Cantidad=$request->input('cantidad');
        $new_entrada->Total=$request->input('total');
        $new_entrada->save();
        return redirect()->route("entradas")->with("success","¡Entrada generada con éxito!");
    }
    public function viewdata(Request $request, $id)
    { 
        $entradas = Entrada::where('id', $id)->first();
        $products = Producto::all();
        //dd($get_product);
        return view('entradas.updatentradas', compact('entradas','products'));
    }
    public function edit(Request $request)
    { 
        $entrada = Entrada::where('id', $request->input('id'))->first();
        $entrada->Produc_id=$request->input('sl_product');
        $entrada->Cantidad=$request->input('cantidad');
        $entrada->Total=$request->input('total');
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
                        $entrada->save();
                        return redirect()->route("show.entrada",[$entrada->id])->with("success","¡Entrada actualizada con éxito!");
                    }
                }
            }
            return redirect()->route("show.entrada",[$entrada->id])->with("error","¡Entrada no actualizada, No tienes autorización!");
        }else{
            $entrada->save();
            return redirect()->route("show.entrada",[$entrada->id])->with("success","¡Entrada actualizada con éxito!");
        }
    }
    public function delete(Request $request)
    { 

    }
}
