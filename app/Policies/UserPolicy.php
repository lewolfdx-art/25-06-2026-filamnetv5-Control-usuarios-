<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Super admin puede hacer todo sin restricciones
     */
    public function before(AuthUser $authUser, $ability): ?bool
    {
        // Si es super_admin, tiene acceso total a TODO
        if ($authUser->hasRole('super_admin')) {
            return true;
        }
        
        // Si no es super_admin, dejamos que los métodos individuales decidan
        return null;
    }

    /**
     * Ver lista de usuarios
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:User');
    }

    /**
     * Ver un usuario específico
     */
    public function view(AuthUser $authUser, $model): bool
    {
        return $authUser->can('View:User');
    }

    /**
     * Crear un nuevo usuario
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    /**
     * Actualizar un usuario
     */
    public function update(AuthUser $authUser, $model): bool
    {
        return $authUser->can('Update:User');
    }

    /**
     * Eliminar un usuario
     */
    public function delete(AuthUser $authUser, $model): bool
    {
        return $authUser->can('Delete:User');
    }

    /**
     * Eliminar múltiples usuarios (en masa)
     */
    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:User');
    }

    /**
     * Restaurar un usuario eliminado
     */
    public function restore(AuthUser $authUser, $model): bool
    {
        return $authUser->can('Restore:User');
    }

    /**
     * Eliminar permanentemente un usuario (force delete)
     */
    public function forceDelete(AuthUser $authUser, $model): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    /**
     * Eliminar permanentemente múltiples usuarios
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    /**
     * Restaurar múltiples usuarios
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    /**
     * Replicar un usuario
     */
    public function replicate(AuthUser $authUser, $model): bool
    {
        return $authUser->can('Replicate:User');
    }

    /**
     * Reordenar usuarios
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }
}