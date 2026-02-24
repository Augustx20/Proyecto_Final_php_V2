<?php

namespace App\Policies;

use App\Models\Turno;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TurnoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // admins can see all, doctors see their own, patients see index but will be filtered in controller
        return in_array($user->role, ['admin', 'doctor']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Turno $turno): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'doctor') {
            return $turno->medico_id === $user->medico_id;
        }

        return $turno->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Turno $turno): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'doctor') {
            return $turno->medico_id === $user->medico_id;
        }

        return $turno->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Turno $turno): bool
    {
         if ($user->role === 'admin') {
             return true;
         }

         if ($user->role === 'doctor') {
             return $turno->medico_id === $user->medico_id;
         }

         return $turno->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Turno $turno): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Turno $turno): bool
    {
        return false;
    }
}
