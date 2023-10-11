<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\SimpleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

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

    public function update(User $user, UpdateRequest $request)
    {
        try {
            $user = $this->userService->updateUser($user, $request->validated());

            return (new UserResource($user))
                ->response()
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

    public function getMyPosts()
    {
        return PostResource::collection(
                $this->userService->getUserPosts(auth()->user())
            )
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
