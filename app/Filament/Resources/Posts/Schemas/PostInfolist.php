<?php
// app/Filament/Resources/Posts/Schemas/PostInfolist.php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 🔥 IMAGEN DESTACADA (SIN borderRadius, SIN rounded)
                ImageEntry::make('featured_image')
                    ->label('Imagen Destacada')
                    ->height(300)
                    ->width(533)
                    ->columnSpanFull(),

                TextEntry::make('title')
                    ->label('Título')
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('content')
                    ->label('Contenido')
                    ->html()
                    ->columnSpanFull(),

                TextEntry::make('author.name')
                    ->label('Autor'),

                IconEntry::make('is_published')
                    ->label('Publicado')
                    ->boolean(),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Creado'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Actualizado'),
            ]);
    }
}