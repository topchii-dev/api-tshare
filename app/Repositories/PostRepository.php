<?php

declare(strict_types=1);

namespace App\Repositories;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline as IlluminatePipeline;


class PostRepository
{
    public function __construct(private IlluminatePipeline $pipeline)
    {
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function getList(array $filters = []): LengthAwarePaginator
    {
        $base_query = Post::query();

        $query = $this->pipeline->send($base_query)
            ->through($filters)
            ->thenReturn();

        return $query
            ->orderByDesc('created_at')
            ->paginate(PostService::PER_PAGE);
    }
}
