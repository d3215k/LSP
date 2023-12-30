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
use Filament\Tables\Actions\ActionGroup;

class AsesmenPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.asesmen-page';

    protected static ?string $title = 'Asesmen';

    protected static ?string $slug = 'asesor/asesmen';

    protected static ?string $navigationGroup = 'Asesor';

    protected static ?int $navigationSort = 3;

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
                ->whereIn('status', [AsesmenStatus::PERSETUJUAN, AsesmenStatus::OBSERVASI_AKTIVITAS, AsesmenStatus::OBSERVASI_PENDUKUNG, AsesmenStatus::TERTULIS_ESAI])
                ->where('asesor_id', auth()->user()->asesor_id),
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi / Skema')
                    ->description(fn (Asesmen $record): string => $record->skema->nama),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('Observasi Aktivitas')
                        ->url(fn (Asesmen $record): string => route('filament.app.pages.asesmen.{record}.ceklis-observasi-aktivitas', $record))
                        ->icon('heroicon-m-document-text'),
                    Action::make('Observasi Pendukung')
                        ->url(fn (Asesmen $record): string => route('filament.app.pages.asesmen.{record}.pertanyaan-observasi-pendukung', $record))
                        ->icon('heroicon-m-document-text'),
                    Action::make('Tertulis Esai')
                        ->url(fn (Asesmen $record): string => route('filament.app.pages.asesmen.{record}.penilaian-asesmen-tertulis-esai', $record))
                        ->icon('heroicon-m-document-text'),
                    Action::make('Rekaman')
                        ->url(fn (Asesmen $record): string => route('filament.app.pages.asesmen.{record}.rekaman', $record))
                        ->icon('heroicon-m-document-text'),
                ])
                ->button()
                ->icon('heroicon-m-document-text')
                ->label('Penilaian')
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
