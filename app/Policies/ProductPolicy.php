<?php
// app/Policies/ProductPolicy.php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        // Super admin y Admin tienen acceso total
        if ($user->hasRole(['super_admin', 'admin'])) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('ViewAny:Product');
    }

    public function view(User $user, Product $product): bool
    {
        // Puede ver si tiene permiso Y es el creador del producto
        return $user->can('View:Product') && $product->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('Create:Product');
    }

    public function update(User $user, Product $product): bool
    {
        // Solo puede editar si tiene permiso Y es el creador
        return $user->can('Update:Product') && $product->user_id === $user->id;
    }

    public function delete(User $user, Product $product): bool
    {
        // Solo puede eliminar si tiene permiso Y es el creador
        return $user->can('Delete:Product') && $product->user_id === $user->id;
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('DeleteAny:Product');
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->can('Restore:Product') && $product->user_id === $user->id;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->can('ForceDelete:Product') && $product->user_id === $user->id;
    }

    public function manageStock(User $user, Product $product): bool
    {
        return $user->can('ManageStock:Product') && $product->user_id === $user->id;
    }

    public function applyDiscount(User $user, Product $product): bool
    {
        return $user->can('ApplyDiscount:Product') && $product->user_id === $user->id;
    }

    public function featureProduct(User $user, Product $product): bool
    {
        return $user->can('FeatureProduct:Product') && $product->user_id === $user->id;
    }

    public function exportProducts(User $user): bool
    {
        return $user->can('ExportProducts:Product');
    }
}