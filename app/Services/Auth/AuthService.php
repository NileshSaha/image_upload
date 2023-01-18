<?php

namespace App\Services\Auth;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ['status' => false, 'message' =>  'The provided credentials are incorrect.'];
        }
        return ['status' => true, 'user' => $user, 'token' => $user->createToken($request->email)->plainTextToken ];
    }

    public function register(RegistrationRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);
        return ['user' => $user, 'token' => $user->createToken($request->email)->plainTextToken];
    }
}
