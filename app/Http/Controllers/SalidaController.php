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

        //$salidas = Salida::all();

        $salidas = Salida::select(
            "salidas.id",
            "salidas.Produc_id",
            "salidas.Cantidad",
            "salidas.Total",
            "productos.Nombre as Nombre"
            )->join("productos","productos.id","=","salidas.Produc_id")
                ->get();
        return view('salidas.allsalidas', compact('salidas'));
    }
    public function index(Request $request)
    { 
        $products = Producto::where("Status","!=","B")->get();
        return view('salidas.salidas', compact('products'));
    }
    public function store(Request $request)
    { 
        $msg = "True";
        $msg2 = "False";
        $new_salida = new Salida();
        $products = Producto::where('id', $request->input('sl_product'))->first();
        //dd($products);
        // $products->Existencias = 1;
        // $products->save();
        $ex_act = $products->Existencias;
        $new_act = $request->input('cantidad');
        $resta = (floatval($ex_act)-floatval($new_act));
//$suma = (floatval($resta)+floatval($request->input('cantidad')));

        if(!is_null($products)){
            $products->Existencias = floatval($resta);
            $products->save();
        }
        $new_salida->Produc_id=$request->input('sl_product');
        $new_salida->Cantidad=$request->input('cantidad');
        $new_salida->Total=$request->input('total');
        if($new_salida->save()){
            return redirect()->route("salidas")->with("success","¡Salida generada con éxito!");
        }
        return redirect()->route("salidas")->with("error","Ha ocurrido un error al registrar la salida!");
    }
    public function viewdata(Request $request, $id, $idp)
    { 
        $salida = Salida::where('id', $id)->first();
        $products = Producto::where("id",$idp)->first();
        //dd($get_product);
        return view('salidas.updatesalida', compact('salida','products'));
    }
    public function edit(Request $request)
    { 
        $idp = $request->input('idp');
        $salida = Salida::where('id', $request->input('id'))->first();
        $products = Producto::where('id', $request->input('idp'))->first();
        
        $suma = (floatval($products->Existencias)+floatval($salida->Cantidad));
        $resta = (floatval($suma)-floatval($request->input('cantidad')));
        $products->Existencias = floatval( $resta);
        
        $salida->Produc_id=$request->input('idp');
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
                        $products->save();
                        return redirect()->route("show.salida",["id"=>$salida->id,"idp"=>$idp])->with("success","¡Salida actualizada con éxito!");
                    }
                }
            }
            return redirect()->route("show.salida",["id"=>$salida->id,"idp"=>$idp])->with("error","¡Salida no actualizada, No tienes autorización!");
        }else{
            $products->save();
            $salida->save();
            return redirect()->route("show.salida",["id"=>$salida->id,"idp"=>$idp])->with("success","¡Salida actualizada con éxito!");
        }
        return redirect()->route("show.salida")->with("error","Ha ocurrido un error al actualizar la salida!");
    }
    public function delete(Request $request)
    { 

    }
}
