<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if (empty($credentials['name']) || empty($credentials['password'])) {
            return response(["message" => 'Informe o nome de usuário e a senha'], 400);
        }
    
        if (auth()->attempt($credentials)) {
            /** @var \App\Models\MyUserModel $user **/
            $expiresIn = now()->addMinutes(config("lifetime"));
            $token = auth()->user()->createToken(date('ymdHisT'))->plainTextToken;
    
            return response(["token" => $token, "expiresIn" => $expiresIn]);
        } else {
            return response(["message" => 'Usuário ou senha inválidos'], 401);
        }
    }
}
