<?php

namespace App\Policies;

use App\User;
use App\UserFirma;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserFirmaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user firma.
     *
     * @param  \App\User  $user
     * @param  \App\UserFirma  $userFirma
     * @return mixed
     */
    public function view(User $user, UserFirma $userFirma)
    {
        //
    }

    /**
     * Determine whether the user can create user firmas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user firma.
     *
     * @param  \App\User  $user
     * @param  \App\UserFirma  $userFirma
     * @return mixed
     */
    public function update(User $user, UserFirma $userFirma)
    {
        return ($user->firma->id == 1);
    }

    /**
     * Determine whether the user can delete the user firma.
     *
     * @param  \App\User  $user
     * @param  \App\UserFirma  $userFirma
     * @return mixed
     */
    public function delete(User $user, UserFirma $userFirma)
    {

    }

    /**
     * Determine whether the user can restore the user firma.
     *
     * @param  \App\User  $user
     * @param  \App\UserFirma  $userFirma
     * @return mixed
     */
    public function restore(User $user, UserFirma $userFirma)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the user firma.
     *
     * @param  \App\User  $user
     * @param  \App\UserFirma  $userFirma
     * @return mixed
     */
    public function forceDelete(User $user, UserFirma $userFirma)
    {
        //
    }
}
