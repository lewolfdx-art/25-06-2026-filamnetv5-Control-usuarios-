<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
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

                Textarea::make('content')
                    ->label('Contenido')
                    ->required()
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