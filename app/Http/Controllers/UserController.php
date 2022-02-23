<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $formFields = $request->only(['email', 'password']);
        if (Auth::attempt($formFields, (bool)$request->get('remember'))) {
            return redirect()->intended();
        }

        return redirect()->back()->withErrors(['email' => 'Неправильный логин или пароль']);
    }

    public function register(Request $request, UserService $userService)
    {
        $user = $userService->create($request->only(['email', 'password']));
        Auth::login($user);
        return redirect()->back();
    }
}
