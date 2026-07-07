<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),

                TextEntry::make('role')
                    ->label('Rol')
                    ->getStateUsing(
                        fn ($record) => 
                            str($record->getRoleNames()->first() ?? 'User')
                                ->replace('_', ' ')
                                ->title()
                    )
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Super Admin' => 'success',
                        'Editor' => 'warning',
                        'Author' => 'info',
                        'Vendedor' => 'primary',
                        default => 'gray',
                    }),

                TextEntry::make('email')
                    ->label('Email address'),

                TextEntry::make('email_verified_at')
                    ->label('Email verificado')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}