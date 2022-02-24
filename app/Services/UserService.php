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

    private $modelManager;

    public function __construct(ManageModelService $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function create(array $data)
    {
        return $this->modelManager->save($data, new User(), self::CREATE_USER_RULES);
    }
}
