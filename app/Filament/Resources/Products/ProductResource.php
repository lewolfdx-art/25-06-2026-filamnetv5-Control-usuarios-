<?php
// app/Filament/Resources/Products/ProductResource.php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\ViewProduct;
use App\Filament\Resources\Products\Schemas\ProductInfolist;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return 'Commerce';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    // 🔥 FORMULARIO SIMPLE - SIN SELECTS
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nombre del Producto')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                \Filament\Forms\Components\RichEditor::make('description')
                    ->label('Descripción Completa')
                    ->columnSpanFull(),

                \Filament\Forms\Components\Textarea::make('short_description')
                    ->label('Descripción Corta')
                    ->maxLength(255)
                    ->rows(2),

                \Filament\Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                \Filament\Forms\Components\TextInput::make('compare_price')
                    ->label('Precio de Referencia')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01),

                \Filament\Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),

                \Filament\Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                \Filament\Forms\Components\TextInput::make('category')
                    ->label('Categoría')
                    ->maxLength(100),

                \Filament\Forms\Components\TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(100),

                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),

                \Filament\Forms\Components\Toggle::make('is_featured')
                    ->label('Destacado')
                    ->default(false),

                \Filament\Forms\Components\Hidden::make('status')
                    ->default('draft'),

                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                \Filament\Forms\Components\Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}