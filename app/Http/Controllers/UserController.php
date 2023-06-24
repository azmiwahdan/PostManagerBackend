<?php

namespace App\Http\Controllers;

use App\Http\services\servicesImpl\LoginService;
use App\Http\services\servicesImpl\UserService;


class UserController extends Controller
{
    protected $loginService, $userService;

    public function __construct(LoginService $loginService, UserService $userService)
    {
        $this->loginService = $loginService;
        $this->userService = $userService;
    }

    public function register()
    {
        return $this->loginService->register(request());
    }

    public function login()
    {
        return $this->loginService->login(request());
    }

    public function updateUser($userId)
    {
        return $this->userService->update($userId, request());
    }

    public function getUserById($userId)
    {
        return $this->userService->getById($userId);
    }

    public function getAllUsers()
    {
        return $this->userService->getAll();
    }

    public function deleteUser($userId)
    {
        return $this->userService->delete($userId);
    }
}
