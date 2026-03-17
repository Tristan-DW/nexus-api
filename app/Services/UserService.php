<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    private const CACHE_TTL = 300; // 5 minutes

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return User::query()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?User
    {
        return Cache::remember("user:{$id}", self::CACHE_TTL, fn () => User::find($id));
    }

    public function create(array $data): User
    {
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'role'          => $data['role'] ?? 'user',
        ]);

        Cache::forget("user:{$user->id}");

        return $user;
    }

    public function update(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        Cache::forget("user:{$user->id}");

        return $user->fresh();
    }

    public function delete(User $user): void
    {
        Cache::forget("user:{$user->id}");
        $user->tokens()->delete();
        $user->delete();
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(20)
            ->get();
    }
}
