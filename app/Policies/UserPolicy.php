<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function admin(User $user)
    {
        return $user->isAdministrator() ? $this->allow() : $this->deny();
    }

    public function accountOwner(User $user, int $accountId)
    {
        $isAccountOwner = !!$user->accounts->where('id', $accountId)->first();

        return $isAccountOwner ? $this->allow() : $this->deny();
    }
}
