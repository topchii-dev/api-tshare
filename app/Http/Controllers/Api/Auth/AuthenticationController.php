<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController
{
    public function __construct(private readonly AuthenticationService $authenticationService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->authenticationService->registerUser($data);

        return $user;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = $this->authenticationService->login($data);

        return $user;
    }

    public function check(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return $user;
        } else {
            return 'Failed';
        }
    }

}
