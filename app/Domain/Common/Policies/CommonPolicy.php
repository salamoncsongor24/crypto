<?php

namespace App\Domain\Common\Policies;

use App\Domain\Admin\Models\Admin;
use App\Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

trait CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function view(Admin|User $user): bool
    {
        return $user->can('view_' . $this->model);
    }

    /**
     * Determine whether the user can view any models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function viewAny(Admin|User $user): bool
    {
        return $user->can('view_any_' . $this->model);
    }

    /**
     * Determine whether the user can create models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function create(Admin|User $user): bool
    {
        return $user->can('create_' . $this->model);
    }

    /**
     * Determine whether the user can update the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function update(Admin|User $user): bool
    {
        return $user->can('update_' . $this->model);
    }

    /**
     * Determine whether the user can restore the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function restore(Admin|User $user): bool
    {
        return $user->can('restore_' . $this->model);
    }

    /**
     * Determine whether the user can restore any models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function restoreAny(Admin|User $user): bool
    {
        return $user->can('restore_any_' . $this->model);
    }

    /**
     * Determine whether the user can replicate the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function replicate(Admin|User $user): bool
    {
        return $user->can('replicate_' . $this->model);
    }

    /**
     * Determine whether the user can reorder models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function reorder(Admin|User $user): bool
    {
        return $user->can('reorder_' . $this->model);
    }

    /**
     * Determine whether the user can delete the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function delete(Admin|User $user): bool
    {
        return $user->can('delete_' . $this->model);
    }

    /**
     * Determine whether the user can delete any models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function deleteAny(Admin|User $user): bool
    {
        return $user->can('delete_any_' . $this->model);
    }

    /**
     * Determine whether the user can force delete the model of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function forceDelete(Admin|User $user): bool
    {
        return $user->can('force_delete_' . $this->model);
    }

    /**
     * Determine whether the user can force delete any models of the given type.
     *
     * @param \App\Domain\Admin\Models\Admin | \App\Domain\User\Models\User $user
     *
     * @return bool
     */
    public function forceDeleteAny(Admin|User $user): bool
    {
        return $user->can('force_delete_any_' . $this->model);
    }
}
