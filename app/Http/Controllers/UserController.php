<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->paginate((int) $request->get('per_page', 20));
        return $this->success(UserResource::collection($users));
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findById($id);
        if (!$user) return $this->notFound('User not found');
        return $this->success(new UserResource($user));
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->userService->update(auth()->user(), $request->validated());
        return $this->success(new UserResource($user), 'Profile updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->authorize('admin');
        $user = $this->userService->findById($id);
        if (!$user) return $this->notFound('User not found');
        $this->userService->delete($user);
        return $this->noContent();
    }

    public function search(Request $request): JsonResponse
    {
        $results = $this->userService->search($request->string('q', ''));
        return $this->success(UserResource::collection($results));
    }
}
