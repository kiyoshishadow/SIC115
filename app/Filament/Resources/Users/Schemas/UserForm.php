<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create') // Requerido solo al crear
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Hashea la contraseña al guardar
                    ->dehydrated(fn ($state) => filled($state)), // Solo guarda si se escribió algo
                TextInput::make('password_confirmation')
                    ->label('Confirmar Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->same('password') // Valida que sea igual al campo 'password'
                    ->dehydrated(false),
            ]);
    }
}
