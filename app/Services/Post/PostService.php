<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Models\Post;
use App\Repositories\PostRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class PostService
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function createPost(array $data): Post
    {
        try {
            $post = $this->postRepository->create($data);
            return $post;

        } catch (Throwable $exception) {
            $message = $exception->getMessage();
            throw new BadRequestHttpException($message);
        }

    }
}
