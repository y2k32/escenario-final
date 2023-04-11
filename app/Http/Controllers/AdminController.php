<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => 
            $request->password], $request->remember)) {
            //return redirect()->intended(route('admin.dashboard'));
            return redirect()->intended(RouteServiceProvider::ADMIN_HAS_CODE);
        }else{
            return back()->with('message','Invalid Email or Password');
        }
        //return redirect()->intended(RouteServiceProvider::HOME);
        //return redirect()->intended(RouteServiceProvider::HAS_CODE);
    }

    public function show(Request $request)
    {
        
    }

}
