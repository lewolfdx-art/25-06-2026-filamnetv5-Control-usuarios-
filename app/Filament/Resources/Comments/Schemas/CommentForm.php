<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 🔥 USUARIO AUTOMÁTICO
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Select::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Selecciona el post al que quieres comentar'),

                Textarea::make('content')
                    ->label('Contenido')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull()
                    ->helperText('Escribe tu comentario aquí'),

                Toggle::make('is_approved')
                    ->label('Aprobado')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger')
                    ->helperText('Si está aprobado, se mostrará en el post'),
            ]);
    }
}