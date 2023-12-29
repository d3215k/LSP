<?php

namespace App\Filament\Pages\Asesor;

use App\Enums\AsesmenStatus;
use App\Models\Asesmen\Mandiri;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Pages\Page;

class AsesmenMandiriPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen-mandiri-page';

    protected static ?string $slug = 'asesor/asesmen-mandiri';

    protected static ?string $title = 'Asesmen Mandiri';

    protected static ?string $navigationGroup = 'Asesor';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesor;
    }

    public function mount()
    {
        if (! auth()->user()->isAsesor) {
            return to_route('filament.app.pages.beranda');
        }
    }

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
                    ->url(fn (Mandiri $record): string => route('filament.app.pages.asesmen-mandiri.{mandiri}.penilaian', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
