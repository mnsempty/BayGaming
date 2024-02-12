<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


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

        DB::beginTransaction();

        try {
            Category::create($validatedData);
            DB::commit();

            return redirect()->route('categories')
                ->with('mensaje', 'Category created successfully.');
        } catch (\Exception $e) {
            db::rollBack();

            Log::error('Error creating category: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['msg' => 'There was a problem creating the category.'])
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

            return redirect()->route('categories')
                ->with('mensaje', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();


            Log::error('Error deleting category: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['msg' => 'There was a problem deleting the category.']);
        }
    }
}
