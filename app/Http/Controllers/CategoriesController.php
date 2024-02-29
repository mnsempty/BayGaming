<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class CategoriesController extends Controller
{
    //
    public function listAll()
    {
        $categories = Category::paginate(5);
        return view('admin.categories', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories-create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:130',
            ]);
        } catch (ValidationException $ev) {
            return back()->withErrors(['message' => 'Error de validación.' . $ev->getMessage()])->withInput();
        }

        try {
            DB::beginTransaction();
            Category::create($validatedData);

            DB::commit();

            return redirect()->route('categories')
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            db::rollBack();

            return redirect()->back()
                ->withErrors(['message' => 'There was a problem creating the category.' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);
            $category->delete();
            DB::commit();

            return redirect()->route('categories')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['message' => 'There was a problem deleting the category.' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);
            $category->update($validatedData);
            DB::commit();

            return redirect()->route('categories')
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['message' => 'There was a problem updating the category.' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.editCategory', compact('category'));
    }
}
