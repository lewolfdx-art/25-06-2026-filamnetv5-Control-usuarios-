<?php
// app/Filament/Resources/Users/Schemas/UserForm.php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1️⃣ NOMBRE
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),

                // 2️⃣ EMAIL
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                // 3️⃣ ROL
                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options(function () {
                        return Role::all()->pluck('name', 'id')->toArray();
                    })
                    ->relationship('roles', 'name')
                    ->columnSpanFull()
                    ->helperText('Selecciona uno o más roles para el usuario'),

                // 4️⃣ CONTRASEÑA (al final)
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }
}