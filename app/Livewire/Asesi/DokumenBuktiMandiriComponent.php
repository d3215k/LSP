<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\Asesmen\BuktiMandiri;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class DokumenBuktiMandiriComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Asesmen $asesmen;

    public $data;

    public function mount() {
        //
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(BuktiMandiri::query())
            ->columns([
                TextColumn::make('nama'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Dokumen')
                    ->model(BuktiMandiri::class)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['asesmen_id'] = $this->asesmen->id;
                        return $data;
                    })
                    ->form([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('file'),
                    ])
                    ->after(fn (Component $livewire) => $livewire->dispatch('dokumenBuktiMandiriMandiriSaved')),

            ])
            ->actions([
                Action::make('Lihat dokumen')
                    ->button()
                    ->icon('heroicon-m-paper-clip')
                    ->url(fn (BuktiMandiri $record): string => asset('storage/'.$record->file))
                    ->openUrlInNewTab(),
                ActionGroup::make([
                    DeleteAction::make()
                        ->after(fn(Component $livewire) => $livewire->dispatch('dokumenBuktiMandiriMandiriSaved')),
                ])
            ])
            ->paginated(false);
    }

    public function handleSubmit(): void
    {
        //
    }

    public function render()
    {
        return view('livewire.asesi.dokumen-bukti-mandiri-component');
    }
}
