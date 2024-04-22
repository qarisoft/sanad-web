<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(User $user):bool|null
    {
        if ($user->is_owner())return true;
        return null;
    }
    public function viewAny(User $user): bool
    {
        return true;
//        return $user->checkPermissionTo('view-any Company');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        return true;
//        return $user->checkPermissionTo('view Company');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
//        return true
            return true;
////        return $user->checkPermissionTo('create Company');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
//        return true
            return true;
////        return $user->checkPermissionTo('update Company');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        return true;
//        return $user->checkPermissionTo('delete Company');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        return true;
//        return $user->checkPermissionTo('restore Company');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return true;
//        return $user->checkPermissionTo('force-delete Company');
    }
}
