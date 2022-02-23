<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService
{
    private const CREATE_USER_RULES = [
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function create(array $data): User
    {
        $validator = $this->validator::make($data, self::CREATE_USER_RULES);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = new User($data);
        if (!$user->save()) {
            throw new \Exception('Error save model');
        }

        return $user;
    }
}
