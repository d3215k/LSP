<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Enums\AsesmenStatus;
use App\Enums\BuktiPersyaratanStatus;
use App\Filament\Resources\AsesmenResource;
use App\Models\Asesi;
use App\Models\Asesmen;
use App\Models\BuktiPersyaratan;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAsesmen extends EditRecord
{
    protected static string $resource = AsesmenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Terima Pengajuan')
                ->action(function (Asesmen $record) {
                    try {
                        $record->update(['status' => AsesmenStatus::ASESMEN_MANDIRI]);
                        Notification::make()->title('Pengajuan diterima!')->success()->send();
                    } catch (\Throwable $th) {
                        Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                        report($th->getMessage());
                    }
                })
                ->requiresConfirmation()
                ->hidden(fn (Asesmen $record) => $record->status->value > AsesmenStatus::REGISTRASI->value),
            Actions\DeleteAction::make(),
        ];
    }
}
