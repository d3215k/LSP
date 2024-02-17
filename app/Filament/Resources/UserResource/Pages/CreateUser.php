<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserType;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = bcrypt('password');
        $data['type'] = UserType::ADMIN;

        return $data;
    }
}
