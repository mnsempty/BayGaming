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
}
