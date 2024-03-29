<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function __invoke()
    {
        return view('templates.template');
    }
    public function roleRedirect(){
        return auth()->check() && auth()->user()->role == 'user' ? redirect()->route('landing') : redirect()->route('dashboard');    }
}
