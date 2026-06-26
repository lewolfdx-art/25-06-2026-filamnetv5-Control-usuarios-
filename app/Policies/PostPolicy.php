<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
     * Ver lista de posts
     */
    public function viewAny(AuthUser $authUser): bool
    {
        // Todos pueden ver la lista, pero el controlador filtrará por usuario
        return $authUser->can('ViewAny:Post');
    }

    /**
     * Ver un post específico
     * CADA USUARIO solo puede ver SUS PROPIOS posts
     */
    public function view(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden ver sus propios posts
        return $authUser->can('View:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Crear un nuevo post
     * CUALQUIER usuario puede crear posts (se asignará automáticamente a él)
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Post');
    }

    /**
     * Actualizar/Editar un post
     * CADA USUARIO solo puede editar SUS PROPIOS posts
     */
    public function update(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden editar sus propios posts
        return $authUser->can('Update:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Eliminar un post (soft delete)
     * CADA USUARIO solo puede eliminar SUS PROPIOS posts
     */
    public function delete(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden eliminar sus propios posts
        return $authUser->can('Delete:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Restaurar un post eliminado
     * CADA USUARIO solo puede restaurar SUS PROPIOS posts
     */
    public function restore(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden restaurar sus propios posts
        return $authUser->can('Restore:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Eliminar permanentemente un post (force delete)
     * CADA USUARIO solo puede eliminar permanentemente SUS PROPIOS posts
     */
    public function forceDelete(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden eliminar permanentemente sus propios posts
        return $authUser->can('ForceDelete:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Publicar un post
     * CADA USUARIO solo puede publicar SUS PROPIOS posts
     */
    public function publish(AuthUser $authUser, Post $post): bool
    {
        // TODOS los usuarios solo pueden publicar sus propios posts
        return $authUser->can('Publish:Post') && $post->user_id === $authUser->id;
    }

    /**
     * Eliminar múltiples posts
     * CADA USUARIO solo puede eliminar SUS PROPIOS posts (en masa)
     */
    public function deleteAny(AuthUser $authUser): bool
    {
        // Esto generalmente se maneja en el controlador filtrando por user_id
        return $authUser->can('DeleteAny:Post');
    }
}