<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class UserService
{
    const PER_PAGE = 10;

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function createUser(array $data): User
    {
        try {
            $user = $this->userRepository->create($data);
            return $user;
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }

    public function updateUser(User $user, array $data): User
    {
        try {
            $user = $this->userRepository->update($user, $data);
            
            return $user;
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }
    }
}
