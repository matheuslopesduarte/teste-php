<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;


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

        if($usuario && Hash::check($request->password, $usuario->password)){

            session(['user' => $usuario]);
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors(['identifier' => 'Usuário ou senha inválidos']);
        }

    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->intended('dashboard');
    }
}
