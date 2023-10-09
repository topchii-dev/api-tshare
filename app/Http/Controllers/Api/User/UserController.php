<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index()
    {
    }

    public function store()
    {
    }

    public function show(User $user)
    {
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function update()
    {
        
    }

    public function getMyPosts()
    {
        return PostResource::collection(
                $this->userService->getUserPosts(auth()->user())
            )
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
