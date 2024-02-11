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
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'real_name' => 'nullable|string|max:255',
                'surname' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'password_confirmation' => 'same:password',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput(); //*Pasa los errores de validación por la vista y los datos introducidos de entrada
        }
        try {
            DB::beginTransaction();
            $user = User::find(auth()->id());
            // buscamos que el email no se encuentre en la base de datos <> el del propio user
            $existingUserWithEmail = User::where('email', $request->email)->where('id', '<>', auth()->id())->first();
            if ($existingUserWithEmail) {
                // salta error si existe email
                throw new \Exception('El correo electrónico ya está en uso.');
            }

            $user->name = $request->name;
            $user->real_name = $request->real_name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            DB::commit();
            return back()->with('mensaje', __('User profile updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Update error: ' . $e->getMessage()]);
        }
    }
    public function showProfile()
    {
        $user = Auth::user();

        // devolver con json los datos de perfil del user
        return response()->json($user);
    
    }
}
