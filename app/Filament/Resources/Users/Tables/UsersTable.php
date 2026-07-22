<?php
// app/Filament/Resources/Users/Tables/UsersTable.php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),

                // 🔥 SWITCH EN LA TABLA CON PROTECCIÓN
                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->toggleable()
                    ->disabled(fn ($record) => 
                        $record->hasRole('super_admin') || // No desactivar Super Admin
                        $record->id === auth()->id()      // No desactivarse a sí mismo
                    )
                    ->tooltip(fn ($record) => 
                        $record->hasRole('super_admin') ? '🔒 No se puede desactivar un Super Admin' :
                        ($record->id === auth()->id() ? '🔒 No puedes desactivarte a ti mismo' : 'Clic para cambiar estado')
                    ),

                TextColumn::make('role')
                    ->label('Role')
                    ->getStateUsing(fn ($record) => $record->getRoleNames()->first() ?? 'User')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'super_admin' => 'cyan',
                        'Admin' => 'danger',
                        'Editor' => 'purple',
                        'Author' => 'success',
                        'Vendedor' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => str($state)->replace('_', ' ')->title())
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('email_verified_at')
                    ->label('Email verificado')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}