<?php

namespace App\Policies;

use App\Models\Turno;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TurnoPolicy
{
    /**
     * Determina si el usuario puede ver cualquier modelo.
     */
    public function viewAny(User $user): bool
    {
        // Los administradores pueden ver todo, los médicos ven los suyos, los pacientes ven el índice pero serán filtrados en el controlador
        return in_array($user->role, ['admin', 'doctor']);
    }

    /**
     * Determina si el usuario puede ver el modelo.
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
     * Determina si el usuario puede crear modelos.
     */
    public function create(User $user): bool
    {
        return auth()->check();
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
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
     * Determina si el usuario puede eliminar el modelo.
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
     * Determina si el usuario puede restaurar el modelo.
     */
    public function restore(User $user, Turno $turno): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente el modelo.
     */
    public function forceDelete(User $user, Turno $turno): bool
    {
        return false;
    }
}
