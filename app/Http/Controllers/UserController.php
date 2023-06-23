<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\services\LoginService;
use App\Models\User;

class UserController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function register()
    {
        return $this->loginService->register(request());

    }

    public function login()
    {
        return $this->loginService->login(request());
    }
}
