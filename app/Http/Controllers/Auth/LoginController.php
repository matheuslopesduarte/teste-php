<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');

    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->identifier)
                            ->orWhere('username', $request->identifier)
                            ->first();

        if($usuario && hash('sha256', $request->password) == $usuario->senha){

            session(['user' => $usuario]);
            return redirect()->route('home');
        } else {
            return back()->withErrors(['identifier' => 'Usuário ou senha inválidos']);
        }

    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('home');
    }
}