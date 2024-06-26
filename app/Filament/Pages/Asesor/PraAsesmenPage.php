<?php

namespace App\Filament\Pages\Asesor;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
use App\Models\Asesmen\Persetujuan;
use App\Models\Sekolah;
use App\Models\Skema;
use App\Models\TempatUjiKompetensi;
use App\Support\Signature;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Pages\Page;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
            return to_route('asesi.beranda');
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Asesmen::query()->latest()
                    ->whereIn('status', [
                        AsesmenStatus::ASESMEN_MANDIRI,
                        AsesmenStatus::PERSETUJUAN
                    ])
                    ->with(['persetujuan'])
                    ->where('asesor_id', auth()->user()->asesor_id)
                    ->whereHas('mandiri', fn ($query) => $query->where('rekomendasi', RekomendasiAsesmenMandiri::DILANJUTKAN))
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Asesmen $record): string => $record->asesi->no_reg ?? '-'),
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
                    ->badge()
                    ->getStateUsing(fn (Asesmen $record): string => $record->persetujuan ? 'Dijadwalkan' : 'Belum Disetujui Asesor')
                    ->sortable(),
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
                Filter::make('persetujuan')
                    ->label('Hanya yang belum disetujui')
                    ->query(fn (Builder $query): Builder => $query->whereDoesntHave('persetujuan'))
                ])
            ->actions([
                Action::make('persetujuan')
                    ->button()
                    ->icon('heroicon-m-document-text')
                    ->url(fn (Asesmen $record): string => route('filament.app.asesmen.resources.asesmens.persetujuan-asesmen-dan-kerahasiaan', $record))
            ])
            ->bulkActions([
                BulkAction::make('persetujuan')
                    ->Action(function (Collection $records, array $data): void {
                        try {
                            DB::beginTransaction();
                            foreach ($records as $record) {
                                Persetujuan::updateOrCreate(
                                    [
                                        'asesmen_id' => $record->id,
                                    ],
                                    $data
                                );
                                if ($record->status = AsesmenStatus::ASESMEN_MANDIRI) {
                                    $record->update(['status' => AsesmenStatus::PERSETUJUAN]);
                                }
                            }
                            DB::commit();
                            Notification::make()->title('Penilaian Berhasil disimpan!')->success()->send();
                        } catch (\Throwable $th) {
                            report($th->getMessage());
                            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
                            DB::rollBack();
                        }
                    })
                    ->form([
                        Forms\Components\Fieldset::make('bukti')
                            ->label('Bukti yang akan dikumpulkan')
                            ->schema([
                                Forms\Components\Checkbox::make('verifikasi_portofolio'),
                                Forms\Components\Checkbox::make('observasi_langsung'),
                                Forms\Components\Checkbox::make('hasil_tes_tulis')->columnSpanFull(),
                                Forms\Components\Checkbox::make('hasil_tes_lisan')->columnSpanFull(),
                                Forms\Components\Checkbox::make('hasil_wawancara')->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Fieldset::make('pelaksanaan')
                            ->label('Pelaksanaan asesmen disepakati pada')
                            ->schema([
                                Forms\Components\DateTimePicker::make('waktu')
                                    ->required()
                                    ->inlineLabel()
                                    ->columnSpanFull(),
                                forms\Components\Select::make('tempat_uji_kompetensi_id')
                                    ->label('Tempat Uji Kompetensi')->inlineLabel()
                                    ->required()
                                    ->options(
                                        TempatUjiKompetensi::query()->pluck('nama', 'id')?->toArray()
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull()
                            ])
                    ])
                    ->deselectRecordsAfterCompletion()
            ]);
    }
}
