<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $login = $this->authService->login($request);
        if ($login['status']) {
            $data = [
                'user' => $login['user'],
                'token' => $login['token']
            ];
            return $this->respond('Login successful', Response::HTTP_ACCEPTED, $data);
        }
        return $this->respond($login['message'], Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegistrationRequest $request)
    {
        $register = $this->authService->register($request);
        $data = [
            'user' => $register['user'],
            'token' => $register['token']
        ];
        return $this->respond('Registration successful', Response::HTTP_ACCEPTED, $data);
    }
}
