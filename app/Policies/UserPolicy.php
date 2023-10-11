<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enum\UserEnum\UserRolesEnum;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return match ($user->role) {
            UserRolesEnum::Admin => true,
            UserRolesEnum::User => $user->id === $model->id,
            default => false
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return match ($user->role) {
            UserRolesEnum::Admin => true,
            default => false
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return match ($user->role) {
            UserRolesEnum::Admin => true,
            default => false
        };
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return match ($user->role) {
            UserRolesEnum::Admin => true,
            default => false
        };
    }
}
