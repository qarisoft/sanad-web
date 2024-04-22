<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
//        return $user->can('view_any_customer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('view_customer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
//        return $user->can('create_customer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('update_customer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('delete_customer');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return true;
//        return $user->can('delete_any_customer');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('force_delete_customer');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
//        return $user->can('force_delete_any_customer');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('restore_customer');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return true;
//        return $user->can('restore_any_customer');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Customer $customer): bool
    {
        return true;
//        return $user->can('replicate_customer');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return true;
//        return $user->can('reorder_customer');
    }
}
