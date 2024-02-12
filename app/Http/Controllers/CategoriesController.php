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
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            // Add validation rules for other fields as needed
        ]);

        $category = Category::create($validatedData);

        return redirect()->route('categories.index')
                         ->with('success','Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            // Add validation rules for other fields as needed
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')
                         ->with('success','Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success','Category deleted successfully.');
    }

}
