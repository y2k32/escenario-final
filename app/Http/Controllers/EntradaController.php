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
        //$entradas = Entrada::all();
        $entradas = Entrada::select(
            "entradas.id",
            "entradas.Produc_id",
            "entradas.Cantidad",
            "entradas.Total",
            "productos.Nombre as Nombre"
            )->join("productos","productos.id","=","entradas.Produc_id")
                ->get();
                //dd($entradas);
        return view('entradas.allentradas', compact('entradas'));
    }
    public function index(Request $request)
    { 
        $products = Producto::where("Status","!=","B")->get();
        return view('entradas.entradas', compact('products'));
    }
    public function store(Request $request)
    { 
        $products = Producto::where('id', $request->input('sl_product'))->first();
        $products->Existencias = ($products->Existencias+$request->input('cantidad'));
        $products->save();
        $new_entrada = new Entrada();
        $new_entrada->Produc_id=$request->input('sl_product');
        $new_entrada->Cantidad=$request->input('cantidad');
        $new_entrada->Total=$request->input('total');
        if($new_entrada->save()){
            return redirect()->route("entradas")->with("success","¡Entrada generada con éxito!");
        }
        return redirect()->route("entradas")->with("success","Ha ocurrido un error al registrar la entrada!");
    }
    public function viewdata(Request $request, $id, $idp)
    { 
        $entradas = Entrada::where('id', $id)->first();
        $products = Producto::where("id",$idp)->first();
        //dd($get_product);
        return view('entradas.updatentradas', compact('entradas','products'));
    }
    public function edit(Request $request)
    { 
        $msg = "True";
        $msg2 = "False";
        $idp = $request->input('idp');
        $products = Producto::where('id', $request->input('idp'))->first();
        //dd($products);
        $entrada = Entrada::where('id', $request->input('id'))->first();
        //dd(floatval($products->Existencias)-floatval($entrada->Cantidad));
        $resta = (floatval($products->Existencias)-floatval($entrada->Cantidad));
        $suma = (floatval($resta)+floatval($request->input('cantidad')));
        // $products->Existencias = 
        // $products->Existencias = 
        if(!is_null($products)){
            $products->Existencias=floatval($suma);//Existencias=$suma;
            $products->save();
            //dd($msg);
        }else{
            //dd($msg2);
        }
        $products->Existencias=$suma;
        $products->save();
        $entrada->Produc_id=$request->input('idp');
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
                        // $products->Existencias=$suma;
                        // $products->save();
                        return redirect()->route("show.entrada",["id"=>$entrada->id,"idp"=>$idp])->with("success","¡Entrada actualizada con éxito!");
                    }
                }
            }
            return redirect()->route("show.entrada",["id"=>$entrada->id,"idp"=>$idp])->with("error","¡Entrada no actualizada, No tienes autorización!");
        }else{
            $products->save();
            $entrada->save();
            return redirect()->route("show.entrada",["id"=>$entrada->id,"idp"=>$idp])->with("success","¡Entrada actualizada con éxito!");
        }
        return redirect()->route("show.entrada")->with("error","Ha ocurrido un error al actualizar la entrada!");
    }
    public function delete(Request $request)
    { 

    }
}
