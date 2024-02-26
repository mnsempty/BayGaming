<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DiscountsController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'percent' => 'required|integer|min:5|max:80',
                'code' => 'required|min:10|regex:/^[A-Za-z0-9@#]+$/',
                'uses' => 'required|integer|min:1',
                //after today validation automatica para la fecha
                'expire_date' => 'nullable|date|after:today',
            ]);
        } catch (ValidationException $e) {
            return back()->with('error', 'Error al crear el descuento: ' . $e->getMessage());
        }

        try {
            DB::beginTransaction();

            $discount = new Discount;
            $discount->percent = $request->percent;
            $discount->code = $request->code;
            $discount->active = true; // por defecto true en db too
            $discount->uses = $request->uses;
            $discount->expire_date = $request->expire_date;
            $discount->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar el descuento: ' . $e->getMessage());
        }

        return redirect()->route('discounts.show')->with('success', 'Descuento creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'percent' => 'required|integer|min:5|max:80',
                'code' => 'required|min:10|regex:/^[A-Za-z0-9@#]+$/',
                'uses' => 'required|integer|min:1',
                'expire_date' => 'nullable|date',
            ]);
        } catch (ValidationException $e) {
            return back()->with('error', 'Error al actualizar el descuento: ' . $e->getMessage());
        }

        try {
            DB::beginTransaction();

            $discount = Discount::findOrFail($id);
            $discount->percent = $request->percent;
            $discount->code = $request->code;
            $discount->uses = $request->uses;
            $discount->expire_date = $request->expire_date;
            $discount->save();
            DB::commit();

            return back()->with('success', 'Descuento actualizado');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al actualizar el descuento: ' . $e->getMessage());
        }
    }

    public function showDiscounts()
    {
        $discounts = Discount::where('active', true)->get();
        $inactiveDiscounts = Discount::where('active', false)->get();
        return view('admin.discounts', compact('discounts', 'inactiveDiscounts'));
    }

    public function deleteDiscount(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->active = false;
            $discount->save();

            return back()->with('success', 'Descuento desactivado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al desactivar el descuento: ' . $e->getMessage());
        }
    }
    // mostrar de nuevo descuentos inactivos
    public function activate(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->active = true;
            $discount->save();

            return back()->with('success', 'Descuento activado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al activar el descuento: ' . $e->getMessage());
        }
    }
}
