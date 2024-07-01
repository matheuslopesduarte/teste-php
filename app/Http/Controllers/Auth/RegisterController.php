<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios,email',
            'cpf' => 'required|string|size:14|unique:usuarios,cpf',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'birthdate' => 'required|date|before:today'
        ]);

        $birthdate = Carbon::parse($request->birthdate);
        $age = $birthdate->age;

        if($age < 18){
            session(['parentRegister' => $request->all()]);
            return redirect()->route('parentRegister');
        } 
        if(!preg_match('/^[a-zA-Z0-9_]*$/', $request->username)){
            return back()->withErrors(['username' => 'invalid characters in username']);
        }

        
        $usuario = new Usuario();

        //handle mail verification
        $misc = [
            'email_verified' => false,
            'email_verification_tokens' => [ 
                'token' => bin2hex(random_bytes(32)),
                'expires_at' => Carbon::now()->addHours(24)->toDateTimeString()
            ],
        ];
        $usuario->misc = json_encode($misc);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->cpf = $request->cpf;
        $usuario->username = $request->username;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return redirect()->route('login');
    }
}