<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;

class User extends Controller
{
    public function register(Request $request, UserService $userService)
    {
        $user = $userService->create($request->only(['email', 'password']));
        return response()->json(['token' => $this->getUserToken($user)]);
    }

    public function login(Request $request)
    {
        $formFields = $request->only(['email', 'password']);
        if (Auth::attempt($formFields)) {
            $user = UserModel::where(['email' => $request->get('email')])->first();
            return response()->json(['token' => $this->getUserToken($user)]);
        }

        return response()->json(['error' => 'Неверны логин или пароль.'], 401);

    }

    public function getUserToken(UserModel $user)
    {
        return $user->createToken('api')->plainTextToken;
    }
}
