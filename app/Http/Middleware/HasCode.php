<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // verifica si el código es válido
        // si no hay un codigo valido te redirecciona a la vista
        // donde se checa el codigo, por que en el metodo store del
        // controlador se genera el codigo
        if ($request->session()->has('code')) {
            return $next($request);
        }
        return redirect()->route('has_code');
        
    }
}
