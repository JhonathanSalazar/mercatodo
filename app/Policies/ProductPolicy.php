<?php

namespace App\Policies;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use App\Entities\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Give the permission to the Super role.
     *
     * @param User $user
     * @return bool|mixed|null
     */
    public function before(User $user)
    {
        if ($user->hasRole(PlatformRoles::SUPER)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CREATE_PRODUCTS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::UPDATE_PRODUCTS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::DELETE_PRODUCTS);
    }

    /**
     * Determine whether the user can import the model.
     *
     * @param User $user
     * @return mixed
     */
    public function import(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::IMPORT);
    }

    /**
     * Determine whether the user can export the model.
     *
     * @param User $user
     * @return mixed
     */
    public function export(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::EXPORT);
    }
}
