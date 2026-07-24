<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesWidget extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return '👤 Usuarios';
    }

    public static function canView(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return $user->hasRole('super_admin');
    }

    protected function getStats(): array
    {
        $roles = Role::withCount('users')->get();
        $stats = [];

        // Usuarios sin rol
        $usuariosSinRol = User::doesntHave('roles')->count();

        foreach ($roles as $role) {
            // 🔥 COLORES IGUAL QUE EN USERS TABLE
            $colores = [
                'super_admin' => 'cyan',
                'Admin' => 'danger',
                'Editor' => 'purple',
                'Author' => 'success',
                'Vendedor' => 'warning',
            ];
            $color = $colores[$role->name] ?? 'gray';

            $stats[] = Stat::make($role->name, $role->users_count)
                ->description($role->users_count == 1 ? 'usuario' : 'usuarios')
                ->color($color)
                ->chart([0, $role->users_count, $role->users_count]);
        }

        // Agregar estadística de usuarios sin rol
        if ($usuariosSinRol > 0) {
            $stats[] = Stat::make('Sin rol', $usuariosSinRol)
                ->description($usuariosSinRol == 1 ? 'usuario sin rol' : 'usuarios sin rol')
                ->color('gray')
                ->chart([0, $usuariosSinRol, $usuariosSinRol]);
        }

        return $stats;
    }
}