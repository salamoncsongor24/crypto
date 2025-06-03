<?php

namespace App\Domain\Portfolio\Policies;

use App\Domain\Admin\Models\Admin;
use App\Domain\Common\Policies\CommonPolicy;
use App\Domain\Portfolio\Models\Portfolio;
use App\Domain\User\Models\User;

class PortfolioPolicy
{
    use CommonPolicy;

    /**
     * The model that this policy applies to.
     *
     * @var string
     */
    protected string $model = 'portfolio';

    /**
     * Determine whether the user can view the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function view(Admin|User $user, Portfolio $model): bool
    {
        return $user->can('view_' . $this->model)
            && $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can update the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function update(Admin|User $user, Portfolio $model): bool
    {
        return $user->can('update_' . $this->model)
            && $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function delete(Admin|User $user, Portfolio $model): bool
    {
        return $user->can('delete_' . $this->model)
            && $user->id === $model->user_id;
    }
}
