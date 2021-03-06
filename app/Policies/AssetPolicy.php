<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Asset $asset
     * @return mixed
     */
    public function view(User $user, Asset $asset)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Asset $asset
     * @return mixed
     */
    public function update(User $user, Asset $asset)
    {
        return $user->id == $asset->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Asset $asset
     * @return mixed
     */
    public function delete(User $user, Asset $asset)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Asset $asset
     * @return mixed
     */
    public function restore(User $user, Asset $asset)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Asset $asset
     * @return mixed
     */
    public function forceDelete(User $user, Asset $asset)
    {
        //
    }
}
