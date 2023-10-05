<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\SimpleResource;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $post = $this->postService->createPost([]);

            return (new PostResource($post))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Throwable $exception) {
            $exception_response = [
                'success' => false,
                'error_key' => $exception->getMessage(),
            ];

            return (new SimpleResource($exception_response))
                ->response()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
