<?php

declare(strict_types=1);

namespace App\Repositories;
use App\Models\Post;


class PostRepository
{
    public function create(array $data): Post
    {
        return Post::create($data);
    }
}
