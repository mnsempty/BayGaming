<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function listAll()
    {
        $categories = Category::paginate(5);
        return view('auth.categories', compact('categories'));
    }
}
