<?php

namespace App\Livewire\Asesi\PermohonanSertifikasiKompetensi;

use App\Models\Asesmen;
use App\Models\Asesmen\BuktiPersyaratan;
use App\Models\Skema\Persyaratan;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class BuktiKelengkapanPemohonComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Asesmen $asesmen;

    public $data;

    public function mount(): void
    {
        //
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Persyaratan::query()->where('skema_id', $this->asesmen->skema_id)
            )
            ->columns([
                TextColumn::make('nama'),
            ])
            ->actions([
                Action::make('Lihat dokumen')
                    ->button()
                    ->icon('heroicon-m-paper-clip')
                    ->url(function (Persyaratan $record): string {
                        return asset('storage/' . $record->bukti()->where('asesmen_id', $this->asesmen->id)->first()?->file);
                    })
                    ->hidden(function (Persyaratan $record): string {
                        return ! $record->bukti()->where('asesmen_id', $this->asesmen->id)->exists();
                    })
                    ->openUrlInNewTab(),
                Action::make('Unggah')
                    ->form([
                        FileUpload::make('file')
                            // ->required(),
                    ])
                    ->button()
                    ->action(function (array $data, Persyaratan $record): void {
                        try {
                            BuktiPersyaratan::updateOrCreate(
                                [
                                    'asesmen_id' => $this->asesmen->id,
                                    'persyaratan_id' => $record->id,
                                ],
                                [
                                    'nama' => $record->nama,
                                    'file' => $data['file'],
                                ]
                            );
                            Notification::make()
                                ->success()
                                ->title('saved')
                                ->send();
                        } catch (\Throwable $th) {
                            report($th->getMessage());

                            Notification::make()
                                ->danger()
                                ->title('saved')
                                ->send();
                        }
                    })
            ])
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.asesi.registrasi.bukti-kelengkapan-pemohon-component');
    }
}
