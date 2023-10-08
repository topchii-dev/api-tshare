<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline as IlluminatePipeline;

class UserRepository
{
    public function __construct(private IlluminatePipeline $pipeline)
    {
    }

    public function getList(array $filters = []): LengthAwarePaginator
    {
        $base_query = User::query();

        $query = $this->pipeline->send($base_query)
            ->through($filters)
            ->thenReturn();

        return $query
            ->orderByDesc('created_at')
            ->paginate(UserService::PER_PAGE);
    }
    
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->refresh();
    }
}
