<?php
// app/Filament/Resources/Posts/Schemas/PostForm.php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload; // 🔥 NUEVO
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                // 🔥 IMAGEN DESTACADA
                FileUpload::make('featured_image')
                    ->label('Imagen Destacada')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1200')
                    ->imageResizeTargetHeight('675')
                    ->directory('posts')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->helperText('Sube una imagen para el post (recomendado: 1200x675 px)'),

                Textarea::make('content')
                    ->label('Contenido')
                    ->required()
                    ->columnSpanFull(),

                Select::make('categories')
                    ->label('Categorías')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                Select::make('tags')
                    ->label('Etiquetas')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Publicado')
                    ->default(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->hidden(fn() => Gate::denies('Publish:Post')),
            ]);
    }
}