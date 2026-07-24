<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * Ver lista de comentarios
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Comment');
    }

    /**
     * Ver un comentario específico
     */
    public function view(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->can('View:Comment');
    }

    /**
     * Crear un nuevo comentario
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Comment');
    }

    /**
     * Actualizar/Editar un comentario
     * CADA USUARIO solo puede editar SUS PROPIOS comentarios
     */
    public function update(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->can('Update:Comment') && $comment->user_id === $authUser->id;
    }

    /**
     * Eliminar un comentario
     * CADA USUARIO solo puede eliminar SUS PROPIOS comentarios
     */
    public function delete(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->can('Delete:Comment') && $comment->user_id === $authUser->id;
    }

    /**
     * Restaurar un comentario eliminado
     * CADA USUARIO solo puede restaurar SUS PROPIOS comentarios
     */
    public function restore(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->can('Restore:Comment') && $comment->user_id === $authUser->id;
    }

    /**
     * Eliminar permanentemente un comentario (force delete)
     * CADA USUARIO solo puede eliminar permanentemente SUS PROPIOS comentarios
     */
    public function forceDelete(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->can('ForceDelete:Comment') && $comment->user_id === $authUser->id;
    }

    /**
     * Aprobar un comentario
     * SOLO ADMIN o SUPER ADMIN pueden aprobar comentarios
     */
    public function approve(AuthUser $authUser, Comment $comment): bool
    {
        return $authUser->hasRole(['super_admin', 'admin']) && $authUser->can('Approve:Comment');
    }

    /**
     * Eliminar múltiples comentarios
     * CADA USUARIO solo puede eliminar SUS PROPIOS comentarios (en masa)
     */
    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Comment');
    }
}