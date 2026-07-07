<?php
// app/Filament/Resources/Products/Pages/ViewProduct.php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver')
                ->url(ProductResource::getUrl('index'))
                ->color('success')
                ->icon('heroicon-o-arrow-left'),
            EditAction::make(),
        ];
    }
}