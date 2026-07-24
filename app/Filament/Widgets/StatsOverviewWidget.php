<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;

class StatsOverviewWidget extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return ' Estadísticas del Sistema';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->description('Publicaciones creadas')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart([7, 3, 5, 8, 12, 9, 15]),

            Stat::make('Total Productos', Product::count())
                ->description('Productos registrados')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning')
                ->chart([5, 8, 6, 10, 14, 11, 18]),

            Stat::make('Total Categorías', Category::count())
                ->description('Categorías disponibles')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info')
                ->chart([2, 3, 4, 4, 5, 5, 6]),
        ];
    }
}