<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    //
    public function updateProfileData(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'real_name' => 'nullable|string|max:255',
                'surname' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors(['message' => 'Error de validación: ' . $e->getMessage()]);
        }
    
        try {
            DB::beginTransaction();
            $user = User::findOrFail(auth()->id());

            $existingUserWithEmail = User::where('email', $request->email)->where('id', '<>', auth()->id())->first();
            if ($existingUserWithEmail) {
                // salta error si existe email
                throw new \Exception('El correo electrónico ya está en uso.');
            }

            $user->name = $request->name;
            $user->real_name = $request->real_name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->save();
            DB::commit();
            return back()->with('success', 'Datos actualizados con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al actualizar el perfíl: ' . $e->getMessage()]);
        }
    }

    public function updatePassword(Request $request)
{
    try {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
    } catch (ValidationException $e) {
        return back()->withErrors(['message' => 'Error de validación: ' . $e->getMessage()]);
    }

    try {
        DB::beginTransaction();
        $user = User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();
        DB::commit();
        return back()->with('success', 'Contraseña actualizada con éxito.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['message' => 'Error al actualizar la contraseña: ' . $e->getMessage()]);
    }
}
    public function showProfile()
    {
        $user = Auth::user();

        // devolver con json los datos de perfil del user
        return response()->json($user);
    
    }
}
