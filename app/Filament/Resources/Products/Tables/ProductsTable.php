<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // ⭐ IMAGEN DEL PRODUCTO (miniatura)
                ImageColumn::make('primaryImage.path')
                    ->label('Imagen')
                    ->height(50)
                    ->width(50)
                    ->square()
                    ->toggleable()
                    ->placeholder('Sin imagen'),

                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('bold'),

                // Precio original
                TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD')
                    ->sortable()
                    ->color('success'),

                // Precio con descuento
                TextColumn::make('final_price')
                    ->label('Precio Final')
                    ->money('USD')
                    ->sortable()
                    ->color(fn ($record) => $record?->is_on_sale ? 'warning' : 'gray')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn ($state) => $state . ' uds'),

                TextColumn::make('category')
                    ->label('Categoría')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                // Switch Activo/Inactivo
                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->toggleable(),

                // Switch Destacado
                ToggleColumn::make('is_featured')
                    ->label('Destacado')
                    ->onColor('warning')
                    ->offColor('gray')
                    ->onIcon('heroicon-o-star')
                    ->offIcon('heroicon-o-star')
                    ->toggleable(),

                // Switch En Oferta
                ToggleColumn::make('is_on_sale')
                    ->label('En Oferta')
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-o-tag')
                    ->offIcon('heroicon-o-tag')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'gray' => 'archived',
                    ])
                    ->toggleable(),

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
                TernaryFilter::make('is_active')
                    ->label('Activo')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),

                TernaryFilter::make('is_featured')
                    ->label('Destacados')
                    ->placeholder('Todos')
                    ->trueLabel('Destacados')
                    ->falseLabel('No destacados'),

                TernaryFilter::make('is_on_sale')
                    ->label('En Oferta')
                    ->placeholder('Todos')
                    ->trueLabel('En oferta')
                    ->falseLabel('Sin oferta'),
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
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }
}