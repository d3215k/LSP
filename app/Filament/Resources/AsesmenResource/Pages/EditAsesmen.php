<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Enums\AsesmenStatus;
use App\Enums\BuktiPersyaratanStatus;
use App\Filament\Resources\AsesmenResource;
use App\Models\Asesi;
use App\Models\Asesmen;
use App\Models\BuktiPersyaratan;
use App\Support\Signature;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

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
            Action::make('Terima')
                ->action(function (Asesmen $record, array $data): void {
                    try {
                        DB::beginTransaction();
                        $ttd = Signature::upload('ttd/asesmen/admin/', $data['ttd_admin'], $record->id);
                        $record->update([
                            'status' => AsesmenStatus::ASESMEN_MANDIRI,
                            'admin_id' => auth()->id(),
                            'ttd_admin' => $ttd
                        ]);
                        DB::commit();
                        Notification::make()->title('Permohonan Sertifikat Kompetensi diterima!')->success()->send();
                    } catch (\Throwable $th) {
                        Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                        report($th->getMessage());
                        DB::rollBack();
                    }
                })
                ->form([
                    Placeholder::make('admin')
                        ->label('Admin (anda)')
                        ->content(auth()->user()->name)
                        ->inlineLabel(),
                    SignaturePad::make('ttd_admin')
                        ->penColor('black')
                        ->penColorOnDark('black')
                        ->inlineLabel()
                        ->label('Tanda tangan Admin'),
                ])
                ->hidden(fn (Asesmen $record) => $record->status->value > AsesmenStatus::REGISTRASI->value || auth()->user()->isAsesor),
            Actions\DeleteAction::make()
                ->hidden(auth()->user()->isAsesor),
        ];
    }
}
