<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function login (Request $request){
        //
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credencialesCorrectas = Auth::attempt($validated);
        if (!$credencialesCorrectas) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = Auth::user();
         $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['message' => 'Usuario autenticado', 'token' => $token], 200);
        
    }
}
