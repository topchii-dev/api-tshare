<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class AuthenticationService
{

    public function registerUser(array $data)
    {
        try {
            $user = new User();
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->username = $data['username'];
            $user->save();

            $output = new UserResource($user);
            $output['token'] = $user->createToken(config('auth.bearer_token'))->plainTextToken;
            return $output;

        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }

    public function login(array $data)
    {
        try {
            if (Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ])) {
                $user = User::find(Auth::id());
                $output = new UserResource($user);
                $output['token'] = $user->createToken(config('auth.bearer_token'))->plainTextToken;
                return $output;
            }
            return 'Failed';
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }
}
