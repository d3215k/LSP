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
use Illuminate\Contracts\Support\Htmlable;

class EditAsesmen extends EditRecord
{
    protected static string $resource = AsesmenResource::class;

    protected static ?string $title = 'FR.APL.01';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Permohonan Sertifikasi Kompetensi';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Terima Pendaftaran')
                ->action(function (Asesmen $record) {
                    try {
                        $record->update(['status' => AsesmenStatus::ASESMEN_MANDIRI]);
                        Notification::make()->title('Pendaftaran diterima!')->success()->send();
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
