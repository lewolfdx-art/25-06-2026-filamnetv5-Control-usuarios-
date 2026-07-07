<?php
// app/Filament/Resources/Products/Schemas/ProductForm.php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Información Básica
                TextInput::make('name')
                    ->label('Nombre del Producto')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                RichEditor::make('description')
                    ->label('Descripción Completa')
                    ->columnSpanFull(),

                Textarea::make('short_description')
                    ->label('Descripción Corta')
                    ->maxLength(255)
                    ->rows(2),

                // Precios y Stock
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                TextInput::make('compare_price')
                    ->label('Precio de Referencia')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->helperText('Precio anterior para mostrar oferta'),

                TextInput::make('cost_price')
                    ->label('Costo')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->helperText('Para calcular ganancias'),

                TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                TextInput::make('barcode')
                    ->label('Código de Barras')
                    ->maxLength(50),

                // Descuentos
                Toggle::make('is_on_sale')
                    ->label('En Oferta')
                    ->live()
                    ->default(false),

                TextInput::make('discount_percentage')
                    ->label('Porcentaje de Descuento')
                    ->numeric()
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%')
                    ->hidden(fn ($get) => !$get('is_on_sale')),

                DateTimePicker::make('discount_start')
                    ->label('Inicio de Oferta')
                    ->hidden(fn ($get) => !$get('is_on_sale')),

                DateTimePicker::make('discount_end')
                    ->label('Fin de Oferta')
                    ->hidden(fn ($get) => !$get('is_on_sale')),

                // Categorización
                TextInput::make('category')
                    ->label('Categoría')
                    ->maxLength(100),

                TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(100),

                TagsInput::make('tags')
                    ->label('Etiquetas'),

                // SEO
                TextInput::make('meta_title')
                    ->label('Meta Título')
                    ->maxLength(60)
                    ->helperText('Máximo 60 caracteres'),

                Textarea::make('meta_description')
                    ->label('Meta Descripción')
                    ->maxLength(160)
                    ->rows(2)
                    ->helperText('Máximo 160 caracteres'),

                TextInput::make('meta_keywords')
                    ->label('Meta Palabras Clave')
                    ->maxLength(255)
                    ->helperText('Separadas por coma'),

                // 🔥 ESTADO - SIN SELECT
                Hidden::make('status')
                    ->default('draft'),

                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),

                Toggle::make('is_featured')
                    ->label('Destacado')
                    ->default(false),

                Hidden::make('user_id')
                    ->default(Auth::id()),

                Hidden::make('created_by')
                    ->default(Auth::id()),
            ]);
    }
}