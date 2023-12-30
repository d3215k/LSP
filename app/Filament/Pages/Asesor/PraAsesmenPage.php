<?php

namespace App\Filament\Pages\Asesor;

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
use Filament\Pages\Page;

class PraAsesmenPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.pra-asesmen-page';

    protected static ?string $title = 'Pra Asesmen';

    protected static ?string $slug = 'asesor/pra-asesmen';

    protected static ?string $navigationGroup = 'Asesor';

    protected static ?int $navigationSort = 2;

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
            ->query(Asesmen::query()
                ->where('status', AsesmenStatus::ASESMEN_MANDIRI)
                ->where('asesor_id', auth()->user()->asesor_id)
                ->whereHas('mandiri', function ($query) {
                    $query->where('rekomendasi', RekomendasiAsesmenMandiri::DILANJUTKAN);
                })->orWhere('status', AsesmenStatus::PERSETUJUAN),
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi'),
                TextColumn::make('skema.nama')
                    ->label('Skema'),
                TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn (Asesmen $record): string => $record->persetujuan()->exists() ? 'Dijadwalkan' : 'Belum disetujui asesor'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('persetujuan')
                    ->button()
                    ->url(fn (Asesmen $record): string => route('filament.app.pages.pra-asesmen.{record}.persetujuan-asesmen-dan-kerahasiaan', $record))
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
