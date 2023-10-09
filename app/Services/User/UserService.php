<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class UserService
{
    const PER_PAGE = 10;

    public function __construct(
            private readonly UserRepository $userRepository,
            private readonly PostRepository $postRepository
        )
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

    public function getUserPosts(User $user)
    {
        $posts = $this->postRepository->getList([
            function ($query, $next) {
                $query->where('author_id', Auth::id());
                return $next($query);
            }
        ]);

        return $posts;
    }
}
