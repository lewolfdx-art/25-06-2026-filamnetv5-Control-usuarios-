<?php
// app/Filament/Resources/Posts/Tables/PostsTable.php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn; // 🔥 NUEVO
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 🔥 MINIATURA DE LA IMAGEN (SIN borderRadius)
                ImageColumn::make('featured_image')
                    ->label('Imagen')
                    ->height(40)
                    ->width(60)
                    ->toggleable()
                    ->rounded(), // 🔥 USAR rounded() EN VEZ DE borderRadius

                TextColumn::make('author.name')
                    ->label('Autor')
                    ->sortable()
                    ->searchable()
                    ->color('warning'),

                TextColumn::make('author_role')
                    ->label('Rol del Autor')
                    ->getStateUsing(fn($record) =>
                        str($record->author?->getRoleNames()->first() ?? 'User')
                            ->replace('_', ' ')
                            ->title()
                    )
                    ->badge()
                    ->color('success')
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),

                TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('tags.name')
                    ->label('Etiquetas')
                    ->badge()
                    ->color('success')
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

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
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}