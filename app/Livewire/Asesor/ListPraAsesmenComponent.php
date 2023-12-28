<?php

namespace App\Livewire\Asesor;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
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

class ListPraAsesmenComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Asesmen::query()
                ->where('status', AsesmenStatus::ASESMEN_MANDIRI)
                ->where('asesor_id', auth()->user()->asesor_id)
                ->whereHas('mandiri', function ($query) {
                    $query->where('rekomendasi', RekomendasiAsesmenMandiri::DILANJUTKAN);
                })
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi'),
                TextColumn::make('skema.nama')
                    ->label('Skema'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('persetujuan')
                    ->button()
                    ->url(fn (Asesmen $record): string => route('filament.app.pages.nilai-asesmen-mandiri.{mandiri}', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.asesor.list-pra-asesmen-component');
    }
}
