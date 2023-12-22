<?php

namespace App\Livewire\Asesi;

use App\Models\BuktiPersyaratan;
use App\Models\Persyaratan;
use App\Models\Skema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class BuktiKelengkapanPemohon extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $signature;

    public $data;

    public function mount(): void
    {
        $skema = Skema::first();

        $this->data['skema'] = $skema;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Persyaratan::query()->where('skema_id', 1) // TODO
            )
            ->columns([
                TextColumn::make('nama'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('Unggah')
                    ->form([
                        TextInput::make('nama')
                            ->required(),
                        FileUpload::make('file')
                            // ->required(),
                    ])
                    ->action(function (array $data, Persyaratan $record): void {
                        try {
                            Notification::make()
                                ->success()
                                ->title('saved')
                                ->send();
                        } catch (\Throwable $th) {
                            Notification::make()
                                ->danger()
                                ->title('saved')
                                ->send();
                        }
                    })
            ])
            ->bulkActions([
                // ...
            ])
            ->paginated(false);
    }

    public function handleSubmit(): void
    {
        dd($this->signature);

        $folderPath = public_path('signature/');

        $image_parts = explode(";base64,", $this->signature);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.'.$image_type;

        file_put_contents($file, $image_base64);
    }

    public function render()
    {
        return view('livewire.asesi.bukti-kelengkapan-pemohon');
    }
}
