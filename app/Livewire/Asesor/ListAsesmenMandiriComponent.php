<?php

namespace App\Livewire\Asesor;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen\Mandiri;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ListAsesmenMandiriComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Mandiri::query()->whereHas('asesmen', function ($query) {
                $query
                    ->where('status', AsesmenStatus::ASESMEN_MANDIRI)
                    ->where('asesor_id', auth()->user()->asesor_id);
            }))
            ->columns([
                TextColumn::make('asesmen.rincianDataPemohon.nama')
                    ->label('Asesi'),
                TextColumn::make('asesmen.skema.nama')
                    ->label('Skema'),
                TextColumn::make('rekomendasi')
                    ->label('Rekomendasi')
                    ->badge(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('nilai')
                    ->button()
                    ->url(fn (Mandiri $record): string => route('filament.app.pages.nilai-asesmen-mandiri.{mandiri}', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.asesor.list-asesmen-mandiri-component');
    }
}
