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

    public function create()
    {
        return view('auth.categories-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        Category::create($validatedData);

        return redirect()->route('categories')
            ->with('mensaje', 'Category created successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories')
            ->with('mensaje', 'Category deleted successfully.');
    }

}
