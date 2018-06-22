<?php

namespace App\Policies;

use EAguad\Model\Order;
use EAguad\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability)
    {
        if ($user->isAdmin() || $user->isSignatory()) {
            return true;
        }
    }

    public function edit(User $user, Order $order)
    {
        return $order->user_id === $user->id || $user->isApprover();
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function approve(User $user, Order $order) : bool
    {
        return $user->isApprover();
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function reject(User $user, Order $order) : bool
    {
        return $user->isApprover();
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function sign(User $user, Order $order) : bool
    {
        return $user->isSignatory() || $user->isAdmin();
    }
}
