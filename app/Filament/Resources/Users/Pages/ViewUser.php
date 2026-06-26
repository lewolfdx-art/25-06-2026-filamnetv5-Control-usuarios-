<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('back')
                ->url($this->getResource()::getUrl('index'))
                ->color('success')
                ->icon('heroicon-o-arrow-left'),
            EditAction::make(),
        ];
    }
}
