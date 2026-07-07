<?php
// app/Policies/UserPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        // Super admin y Admin tienen acceso total a usuarios
        if ($user->hasRole(['super_admin', 'admin'])) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('ViewAny:User');
    }

    public function view(User $user): bool
    {
        return $user->can('View:User');
    }

    public function create(User $user): bool
    {
        return $user->can('Create:User');
    }

    public function update(User $user): bool
    {
        return $user->can('Update:User');
    }

    public function delete(User $user): bool
    {
        return $user->can('Delete:User');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('DeleteAny:User');
    }

    public function restore(User $user): bool
    {
        return $user->can('Restore:User');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('ForceDelete:User');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('ForceDeleteAny:User');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('RestoreAny:User');
    }

    public function replicate(User $user): bool
    {
        return $user->can('Replicate:User');
    }

    public function reorder(User $user): bool
    {
        return $user->can('Reorder:User');
    }
}