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
        // admins can see all; regular users only their own turnos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Turno $turno): bool
    {
        return $user->role === 'admin' || $turno->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // any authenticated user can create a turno
        return $user->role === 'admin' || $user->role === 'user';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Turno $turno): bool
    {
        return $this->view($user, $turno);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Turno $turno): bool
    {
        return $this->view($user, $turno);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Turno $turno): bool
    {
        return $this->view($user, $turno);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Turno $turno): bool
    {
        return $user->role === 'admin';
    }
}
