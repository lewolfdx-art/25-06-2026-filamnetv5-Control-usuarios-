<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
                // ========================================
                // 1. INFORMACIÓN BÁSICA
                // ========================================

                // Nombre del Producto
                TextInput::make('name')
                    ->label('Nombre del Producto')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                // Slug / URL Amigable
                TextInput::make('slug')
                    ->label('Slug / URL Amigable')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Se genera automáticamente mientras escribes el nombre.'),

                // Descripción
                RichEditor::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),

                // ========================================
                // 2. PRECIO Y STOCK
                // ========================================

                // Precio
                TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                // Stock
                TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                // ========================================
                // 3. DESCUENTOS
                // ========================================

                // En Oferta (Switch)
                Toggle::make('is_on_sale')
                    ->label('En Oferta')
                    ->live()
                    ->default(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->helperText('Activa para aplicar un descuento al producto.'),

                // Porcentaje de Descuento
                TextInput::make('discount_percentage')
                    ->label('Porcentaje de Descuento')
                    ->numeric()
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%')
                    ->hidden(fn ($get) => !$get('is_on_sale')),

                // ========================================
                // 4. GALERÍA DE IMÁGENES
                // ========================================

                Repeater::make('images')
                    ->label('Galería de Imágenes')
                    ->relationship('images')
                    ->schema([
                        FileUpload::make('path')
                            ->label('Imagen')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('800')
                            ->directory('products')
                            ->visibility('public')
                            ->required()
                            ->helperText('Formatos permitidos: JPG, PNG, WEBP.'),
                        Toggle::make('is_primary')
                            ->label('Imagen Principal')
                            ->default(false)
                            ->helperText('Marca esta imagen como la principal del producto.'),
                    ])
                    ->columnSpanFull()
                    ->helperText('Sube imágenes para el producto. La primera será la principal.'),

                // ========================================
                // 5. DESTACADO
                // ========================================

                // Destacado (Switch)
                Toggle::make('is_featured')
                    ->label('Destacado')
                    ->default(false)
                    ->onColor('warning')
                    ->offColor('gray')
                    ->helperText('Los productos destacados aparecen en la sección principal.'),

                // ========================================
                // 6. ESTADO
                // ========================================

                // Estado
                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'published' => 'Publicado',
                        'archived' => 'Archivado',
                    ])
                    ->default('draft')
                    ->required(),

                // Activo (Switch)
                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger')
                    ->helperText('Desactiva para ocultar el producto temporalmente.'),

                // ========================================
                // 7. CAMPOS OCULTOS
                // ========================================

                Hidden::make('user_id')
                    ->default(Auth::id()),

                Hidden::make('created_by')
                    ->default(Auth::id()),
            ]);
    }
}