<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\UserCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProductoController extends Controller
{
    //
    public function allproducts(Request $request)
    {
        $products = Producto::all();
        return view('products.allproducts', compact('products'));
    }
    public function index(Request $request)
    { 
        return view('products.products');
    }
    public function store(Request $request)
    { 
        $new_product = new Producto();
        //dd($request);
        //dd($request); si llegan los datos del request
        //dd($request->hasFile('imgp'));
        if($request->hasFile('imgp')){
            $file = $request->file('imgp');
            //dd($file);
            $finalPath = 'img/';
            $filename = time() . '-' .$file->getClientOriginalName();
            $uploadFile = $request->file('imgp')->move($finalPath, $filename);
            $new_product->Img = $finalPath.$filename;
        }
        $new_product->Nombre=$request->input('nombre');
        $new_product->Existencias=$request->input('existencia');
        $new_product->Precio=$request->input('precio');
        $new_product->PrecioCompra=$request->input('precio_p');
        $new_product->Codigo=$request->input('codigo');
        $new_product->Status="A";
        $new_product->save();
        return redirect()->route("products")->with("success","¡Producto agendado con éxito!.");
    }
    public function viewdata(Request $request, $id)
    { 
        $products = Producto::where('id', $id)->first();
        //dd($get_product);
        return view('products.updateproducts', compact('products'));
    }
    public function viewdata2(Request $request, $id)
    { 
        $products = Producto::where('id', $id)->first();
        //dd($get_product);
        return view('products.delproduct', compact('products'));
    }
    public function edit(Request $request)
    { 
        $actualiza = false;
        $products = Producto::where('id', $request->input('id'))->first();
        $products->Nombre=$request->input('nombre');
        $products->Existencias=$request->input('existencia');
        $products->Precio=$request->input('precio');
        $products->PrecioCompra=$request->input('precio_p');
        $products->Codigo=$request->input('codigo');
        //$products->Status=$request->input('status');
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
                        $products->save();
                        return redirect()->route("show.product",[$products->id])->with("success","¡Producto actualizado con éxito!");
                    }
                }
            }
            return redirect()->route("show.product",[$products->id])->with("error","¡Producto no actualizado, No tienes autorización!");
        }else{
            $products->save();
            return redirect()->route("show.product",[$products->id])->with("success","¡Producto actualizado con éxito!");
        }
    }
    
    public function delete(Request $request)
    { 
        $products = Producto::where('id', $request->input('id'))->first();
        $products->Status='B';
        if(Auth::user()->rol == 3 && Auth::user()->rol == 2){
            $codigo_v = $request->input('codigo_v');
            $has_code_v = UserCode::where('code', "!=","")->where('rol',1)
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
                        $products->save();
                        return redirect()->route("show.product",[$products->id])->with("success","¡Producto actualizado con éxito!");
                    }
                }
            }
            return redirect()->route("show.product",[$products->id])->with("error","¡Producto no actualizado, No tienes autorización!");
        }else{
            $products->save();
            return redirect()->route("show.product",[$products->id])->with("success","¡Producto actualizado con éxito!");
        }
    }
}
