<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Información Básica
                TextEntry::make('name')
                    ->label('Nombre del Producto')
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('slug')
                    ->label('Slug / URL')
                    ->copyable()
                    ->color('gray'),

                TextEntry::make('description')
                    ->label('Descripción')
                    ->html()
                    ->columnSpanFull(),

                // Precios
                TextEntry::make('price')
                    ->label('Precio')
                    ->money('USD')
                    ->size('lg')
                    ->weight('bold')
                    ->color('success'),

                TextEntry::make('final_price')
                    ->label('Precio Final (con descuento)')
                    ->money('USD')
                    ->badge()
                    ->color('warning')  // 🔥 CAMBIADO badgeColor() por color()
                    ->hidden(fn ($record) => !$record?->is_on_sale),

                // Stock
                TextEntry::make('stock')
                    ->label('Stock Disponible')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn ($state) => $state . ' unidades'),

                // Estado
                TextEntry::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'gray' => 'archived',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                        default => $state,
                    }),

                // Activo
                IconEntry::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                // Destacado
                IconEntry::make('is_featured')
                    ->label('Destacado')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                // En Oferta
                IconEntry::make('is_on_sale')
                    ->label('En Oferta')
                    ->boolean()
                    ->trueIcon('heroicon-o-tag')
                    ->falseIcon('heroicon-o-tag')
                    ->trueColor('success')
                    ->falseColor('gray'),

                // Auditoría
                TextEntry::make('user.name')
                    ->label('Creado por'),

                TextEntry::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}