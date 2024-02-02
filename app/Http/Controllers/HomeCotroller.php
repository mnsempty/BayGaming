<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeCotroller extends Controller
{
    //
    public function __invoke()
    {
        return view('templates.template');
    }
    public function roleRedirect(){
       return auth()->check() && auth()->user()->role == 'user' ? view('landing') : redirect()->route('dashboard'); 
    }
}
