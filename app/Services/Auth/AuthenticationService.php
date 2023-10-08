<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class AuthenticationService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Create new user and generate 
     * a token upon registration.
     *
     * @param array $data
     * 
     * @return UserResource
     */
    public function registerUser(array $data): UserResource
    {
        try {
            $user = $this->userRepository->create($data);
            $output = new UserResource($user);

            $output['token'] = $user->createToken(config('auth.bearer_token'))->plainTextToken;
            return $output;

        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }

    /**
     * Attempt to login the user. Return false if failed.
     *
     * @param array $data
     * 
     * @return UserResource|boolean
     */
    public function login(array $data): UserResource|bool
    {
        try {
            if (Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ])) {
                $user = Auth::user();
                $output = new UserResource($user);

                $output['token'] = $user->createToken(config('auth.bearer_token'))->plainTextToken;
                return $output;
            }
            return false;
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }

    /**
     * Logout the user and delete active tokens.
     *
     * @return integer|boolean
     */
    public function logout(): int|bool
    {
        try {
            $user = Auth::user();
            return $user? $user->tokens()->delete() : false;

        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }

    public function check()
    {
        return Auth::user();
    }
}
