<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\SimpleResource;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthenticationController
{
    public function __construct(private readonly AuthenticationService $authenticationService)
    {
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->authenticationService->registerUser($data);

            return response($user)
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (Throwable $exc) {
            $exception_response = [
                'success' => false, 
                'error' => $exc->getMessage()
            ];

            return (new SimpleResource($exception_response))
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = $this->authenticationService->login($data);

        return response(
                $user? $user : (new SimpleResource(['message' => 'Invalid credentials']))
            )
            ->setStatusCode(
                $user? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED
            );
    }

    public function logout()
    {
        $output = $this->authenticationService->logout();
        return response($output)
            ->setStatusCode(Response::HTTP_OK);
    }

    public function check(Request $request)
    {
        $output = $this->authenticationService->check();
        return (new SimpleResource($output))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

}
