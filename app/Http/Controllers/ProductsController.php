<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // Create Read Update Delete
    // crear producto mediante una transacción
    // 
    public function crearProduct(Request $request)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear un producto']);
        }
    }
}
