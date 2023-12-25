<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Akses Asesor')
                ->action(function () {
                    Artisan::call('app:generate-users');
                    Notification::make()->title('User berhasil di generate!')->success()->send();
                })
                ->requiresConfirmation(),
            Actions\CreateAction::make(),
        ];
    }
}
