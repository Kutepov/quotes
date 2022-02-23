<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $formFields = $request->only(['email', 'password']);
        if (Auth::attempt($formFields, (bool)$request->get('remember'))) {
            return redirect()->intended();
        }

        return redirect()->back()->withErrors(['email' => 'Неправильный логин или пароль']);
    }
}
