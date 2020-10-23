<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can edit the model.
     * @param User $user
     * @param Order $order
     * @return mixed
     */
    public function edit(User $user, Order $order): bool
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id == $order->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->id == $order->user_id;
    }
}
