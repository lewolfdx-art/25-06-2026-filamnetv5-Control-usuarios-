<?php
// app/Filament/Resources/Products/Schemas/ProductInfolist.php

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
                    ->label('Descripción Completa')
                    ->html()
                    ->columnSpanFull(),

                TextEntry::make('short_description')
                    ->label('Descripción Corta')
                    ->columnSpanFull()
                    ->placeholder('Sin descripción corta'),

                // Precios
                TextEntry::make('price')
                    ->label('Precio')
                    ->money('USD')
                    ->size('lg')
                    ->weight('bold')
                    ->color('success'),

                TextEntry::make('compare_price')
                    ->label('Precio de Referencia')
                    ->money('USD')
                    ->color('gray')
                    ->placeholder('Sin precio de referencia'),

                TextEntry::make('cost_price')
                    ->label('Costo')
                    ->money('USD')
                    ->color('gray')
                    ->placeholder('Sin costo registrado'),

                TextEntry::make('final_price')
                    ->label('Precio Final (con descuento)')
                    ->money('USD')
                    ->badge()
                    ->badgeColor('warning')
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

                TextEntry::make('sku')
                    ->label('SKU / Código Interno')
                    ->copyable()
                    ->badge()
                    ->color('info')
                    ->placeholder('Sin SKU asignado'),

                TextEntry::make('barcode')
                    ->label('Código de Barras')
                    ->copyable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('Sin código de barras'),

                // Descuentos
                IconEntry::make('is_on_sale')
                    ->label('En Oferta')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                TextEntry::make('discount_percentage')
                    ->label('Porcentaje de Descuento')
                    ->suffix('%')
                    ->badge()
                    ->color('danger')
                    ->hidden(fn ($record) => !$record?->is_on_sale)
                    ->placeholder('Sin descuento'),

                TextEntry::make('discount_start')
                    ->label('Inicio de Oferta')
                    ->dateTime()
                    ->hidden(fn ($record) => !$record?->is_on_sale)
                    ->placeholder('No iniciada'),

                TextEntry::make('discount_end')
                    ->label('Fin de Oferta')
                    ->dateTime()
                    ->hidden(fn ($record) => !$record?->is_on_sale)
                    ->placeholder('Sin fecha de fin'),

                // Categorización
                TextEntry::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->color('info')
                    ->placeholder('Sin categoría'),

                TextEntry::make('brand')
                    ->label('Marca')
                    ->badge()
                    ->color('primary')
                    ->placeholder('Sin marca'),

                TextEntry::make('tags')
                    ->label('Etiquetas')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->placeholder('Sin etiquetas'),

                // SEO
                TextEntry::make('meta_title')
                    ->label('Meta Título')
                    ->copyable()
                    ->placeholder('Sin meta título'),

                TextEntry::make('meta_description')
                    ->label('Meta Descripción')
                    ->copyable()
                    ->placeholder('Sin meta descripción'),

                TextEntry::make('meta_keywords')
                    ->label('Meta Palabras Clave')
                    ->copyable()
                    ->placeholder('Sin meta palabras clave'),

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

                IconEntry::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconEntry::make('is_featured')
                    ->label('Destacado')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
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

                TextEntry::make('deleted_at')
                    ->label('Eliminado')
                    ->dateTime()
                    ->color('danger')
                    ->visible(fn ($record) => $record?->deleted_at !== null),
            ]);
    }
}