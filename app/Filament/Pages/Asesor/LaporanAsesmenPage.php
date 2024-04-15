<?php

namespace App\Filament\Pages\Asesor;

use Filament\Pages\Page;

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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class LaporanAsesmenPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.laporan-asesmen-page';

    protected static ?string $title = 'Laporan Asesmen';

    protected static ?string $slug = 'asesor/laporan-asesmen';

    protected static ?string $navigationGroup = 'Asesor';

    protected static ?int $navigationSort = 4;

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
            ->query(Asesmen::query()->latest()
                ->whereIn('status', [AsesmenStatus::SELESAI_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT])
                ->where('asesor_id', auth()->user()->asesor_id),
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi / Skema')
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
                TextColumn::make('rekaman.rekomendasi')
                    ->label('Rekomendasi')
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
                Action::make('Rekaman')
                    ->button()
                    ->url(fn (Asesmen $record): string => route('filament.app.resources.asesmens.rekaman', $record))
                    ->icon('heroicon-m-document-text'),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
