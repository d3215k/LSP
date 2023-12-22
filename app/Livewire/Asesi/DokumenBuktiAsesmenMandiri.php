<?php

namespace App\Livewire\Asesi;

use App\Models\BuktiAsesmenMandiri;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class DokumenBuktiAsesmenMandiri extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $data;

    public function table(Table $table): Table
    {
        return $table
            ->query(BuktiAsesmenMandiri::query())
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('deskripsi'),
                TextColumn::make('file'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->model(BuktiAsesmenMandiri::class)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['asesmen_id'] = 1;
                        return $data;
                    })
                    ->form([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('deskripsi')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('file'),
                    ])
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->paginated(false);
    }

    public function handleSubmit(): void
    {
        //
    }

    public function render()
    {
        return view('livewire.asesi.dokumen-bukti-asesmen-mandiri');
    }
}
