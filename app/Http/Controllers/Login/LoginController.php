<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
   public function index()
   {
       return view('login');
   }
   public function login(Request $request)
   {
       // Validate the request data
       $request->validate([
           'nombre_usuario' => 'required|string|max:255',
           'contrasena' => 'required|min:6',
       ]);
        
 $usuario = $request->nombre_usuario;
       $password = $request->contrasena;

       $usuario=Usuario::where('nombre_usuario', $usuario)->first();


if (!$usuario) {
           return redirect('/login')->withErrors(['error' => 'Usuario no encontrado.']);
       }


//verificacion de password 
 if (!Hash::check($password, $usuario->contrasena_hash)) {
    return redirect('/login')->withErrors(['error' => 'Contraseña incorrecta.']);
}
session(['usuario' => $usuario->nombre_usuario]);
return redirect('/home')->with('success', 'Inicio de sesión exitoso.');
   }

}

