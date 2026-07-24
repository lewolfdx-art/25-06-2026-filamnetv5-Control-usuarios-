<?php

namespace App\Filament\Resources\Comments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                // 🔥 QUIEN ESCRIBIÓ EL COMENTARIO
                TextColumn::make('user.name')
                    ->label('Comentado por')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('warning'),

                // 🔥 POST DONDE SE COMENTÓ
                TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->color('gray'),

                // 🔥 AUTOR DEL POST (USANDO GETSTATEUSING)
                TextColumn::make('post_author')
                    ->label('Autor del Post')
                    ->getStateUsing(fn ($record) => $record->post?->author?->name ?? 'Sin autor')
                    ->searchable()
                    ->sortable()
                    ->color('info'),

                TextColumn::make('content')
                    ->label('Contenido')
                    ->limit(50),

                IconColumn::make('is_approved')
                    ->label('Aprobado')
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
                SelectFilter::make('is_approved')
                    ->label('Estado')
                    ->options([
                        '0' => 'Pendiente',
                        '1' => 'Aprobado',
                    ]),

                SelectFilter::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Ver'),
                EditAction::make()
                    ->label('Editar'),
                DeleteAction::make()
                    ->label('Eliminar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Eliminar Seleccionados'),
                ]),
            ]);
    }
}