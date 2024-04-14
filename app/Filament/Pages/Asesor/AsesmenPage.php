<?php

namespace App\Filament\Pages\Asesor;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
use App\Models\Sekolah;
use App\Models\Skema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Actions\ActionGroup;
use Filament\Pages\Page;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

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
            return to_route('asesi.beranda');
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Asesmen::query()->latest()
                    ->whereIn('status', [AsesmenStatus::PERSETUJUAN, AsesmenStatus::OBSERVASI_AKTIVITAS, AsesmenStatus::OBSERVASI_PENDUKUNG, AsesmenStatus::TERTULIS_ESAI])
                    ->where('asesor_id', auth()->user()->asesor_id)
                    ->with('tertulisEsai', 'observasiAktivitas', 'observasiPendukung'),
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi')
                    ->searchable()
                    ->description(fn (Asesmen $record): string => $record->asesi->no_reg),
                TextColumn::make('asesi.sekolah.nama')
                    ->label('Asal Sekolah')
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: false,
                    )
                    ->sortable(),
                TextColumn::make('skema.nama')
                    ->wrap()
                    ->label('Skema'),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('Asal Sekolah')
                    ->options(
                        fn() => Sekolah::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'asesi',
                                fn (Builder $query) => $query->whereHas(
                                    'sekolah',
                                    fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                                )
                            );
                        }
                    }),
                SelectFilter::make('Skema')
                    ->options(
                        fn() => Skema::query()
                            ->whereHas(
                                'asesor',
                                fn (Builder $query) => $query->where('asesor_id', auth()->user()->asesor_id)
                            )
                            ->pluck('nama', 'id')->toArray(),
                    )
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->where('skema_id', '=', (int) $data['value']);
                        }
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('Observasi Aktivitas')
                        ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.ceklis-observasi-aktivitas', $record))
                        ->icon('heroicon-m-document-text'),
                    Action::make('Observasi Pendukung')
                        ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.pertanyaan-observasi-pendukung', $record))
                        ->icon('heroicon-m-document-text'),
                    Action::make('esai')
                        ->label('Tertulis Esai')
                        ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.pertanyaan-tertulis-esai', $record))
                        ->icon('heroicon-m-document-text')
                        ->hidden(fn (Asesmen $record): bool => !$record->tertulisEsai),
                    Action::make('pg')
                        ->label('Tertulis PG')
                        ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.pertanyaan-tertulis-pilihan-ganda', $record))
                        ->icon('heroicon-m-document-text')
                        ->hidden(fn (Asesmen $record): bool => !$record->tertulisPilihanGanda),
                    Action::make('Rekaman')
                        ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.rekaman', $record))
                        ->icon('heroicon-m-document-text')
                        ->hidden(fn (Asesmen $record): bool => !$record->observasiAktivitas || !$record->observasiPendukung),
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
