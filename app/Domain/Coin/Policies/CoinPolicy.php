<?php

namespace App\Domain\Coin\Policies;

use App\Domain\Admin\Models\Admin;
use App\Domain\Common\Policies\CommonPolicy;
use App\Domain\User\Models\User;

class CoinPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'coin';

    /**
     * Determine whether the user can activate the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function activate(Admin|User $user): bool
    {
        return $user->can('activate_' . $this->model);
    }

    /**
     * Determine whether the user can deactivate the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function deactivate(Admin|User $user): bool
    {
        return $user->can('deactivate_' . $this->model);
    }

    /**
     * Determine whether the user can change the amount of the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function changeAmount(Admin|User $user): bool
    {
        return $user->can('change_amount_' . $this->model);
    }
}
