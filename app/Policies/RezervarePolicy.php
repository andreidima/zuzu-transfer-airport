<?php

namespace App\Policies;

use App\User;
use App\Rezervare;
use Illuminate\Auth\Access\HandlesAuthorization;

class RezervarePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rezervare.
     *
     * @param  \App\User  $user
     * @param  \App\Rezervare  $rezervare
     * @return mixed
     */
    public function view(User $user, Rezervare $rezervare)
    {
        //
    }

    /**
     * Determine whether the user can create rezervares.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the rezervare.
     *
     * @param  \App\User  $user
     * @param  \App\Rezervare  $rezervare
     * @return mixed
     */
    public function update(User $user, Rezervare $rezervare)
    {
        return ($user->is($rezervare->user) || ($user->firma->id == 1));
    }

    /**
     * Determine whether the user can delete the rezervare.
     *
     * @param  \App\User  $user
     * @param  \App\Rezervare  $rezervare
     * @return mixed
     */
    public function delete(User $user, Rezervare $rezervare)
    {
        return ($user->firma->id == 1);
    }

    /**
     * Determine whether the user can restore the rezervare.
     *
     * @param  \App\User  $user
     * @param  \App\Rezervare  $rezervare
     * @return mixed
     */
    public function restore(User $user, Rezervare $rezervare)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the rezervare.
     *
     * @param  \App\User  $user
     * @param  \App\Rezervare  $rezervare
     * @return mixed
     */
    public function forceDelete(User $user, Rezervare $rezervare)
    {
        //
    }
}
