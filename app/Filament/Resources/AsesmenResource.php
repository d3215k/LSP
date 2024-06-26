<?php

namespace App\Filament\Resources;

use App\Enums\AsesmenStatus;
use App\Enums\TujuanAsesmen;
use App\Enums\UserType;
use App\Filament\Clusters\Asesmen as ClustersAsesmen;
use App\Filament\Resources\AsesmenResource\Pages;
use App\Filament\Resources\AsesmenResource\RelationManagers;
use App\Models\Asesmen;
use App\Models\Asesor;
use App\Models\Periode;
use App\Models\Sekolah;
use App\Support\Signature;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class AsesmenResource extends Resource
{
    protected static ?string $model = Asesmen::class;

    protected static ?string $cluster = ClustersAsesmen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'FR.APL.01';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return auth()->user()->isAdmin;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->disabled(auth()->user()->isAsesor)
            ->schema([
                Forms\Components\Select::make('skema_id')
                    ->relationship('skema', 'nama')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('periode_id')
                    ->relationship('periode', 'nama')
                    ->options(Periode::all()->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\Select::make('tujuan')
                    ->options(TujuanAsesmen::class),
                Fieldset::make('A. Data Pribadi')
                    ->relationship('rincianDataPemohon')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required(),
                        TextInput::make('no_identitas')
                            ->label('No KTP/NIK/Paspor')
                            ->required(),
                        Radio::make('jk')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => "Laki-laki",
                                'P' => "Perempuan",
                            ])
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required(),
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        TextInput::make('kebangsaan')
                            ->label('Kebangsaan')
                            ->required(),
                        TextInput::make('alamat_rumah')
                            ->label('Alamat')
                            ->required(),
                        TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->required(),
                        TextInput::make('no_telepon_rumah')
                            ->label('No Telepon (Rumah)')
                            ->required(),
                        TextInput::make('no_telepon_hp')
                            ->label('No Telepon (HP aktif WhatsApp)')
                            ->required(),
                        TextInput::make('kualifikasi_pendidikan')
                            ->label('Kualifikasi Pendidikan')
                            ->required(),
                    ])
                    ->columns(2),
                Fieldset::make('B. Data Pekerjaan Sekarang')
                    ->relationship('rincianDataPemohon')
                    ->schema([
                        TextInput::make('nama_institusi')
                            ->label('Nama Institusi / Perusahaan')
                            ->required(),
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required(),
                        TextInput::make('alamat_kantor')
                            ->label('Alamat Kantor')
                            ->required(),
                        TextInput::make('kode_pos_kantor')
                            ->label('Kode Pos Kantor')
                            ->required(),
                        TextInput::make('no_telepon_kantor')
                            ->label('No Telepon Kantor')
                            ->required(),
                        TextInput::make('no_fax_kantor')
                            ->label('No Fax Kantor')
                            ->required(),
                        TextInput::make('email_kantor')
                            ->label('Email Kantor')
                            ->required(),
                    ]),
                Fieldset::make('Tanda tangan Asesi')
                    ->hidden(auth()->user()->isAsesor)
                    ->schema([
                        FileUpload::make('ttd_asesi')
                            ->label('Asesi')
                            ->directory('ttd/asesmen/asesi')
                            ->image()
                            ->maxSize(1024),
                    ]),
                Fieldset::make('Asesor')
                    ->hidden(auth()->user()->isAsesor)
                    ->schema([
                        FileUpload::make('ttd_asesor')
                            ->label('Tanda tangan Asesor')
                            ->directory('ttd/asesmen/asesor')
                            ->image()
                            ->maxSize(1024),
                        Forms\Components\Select::make('asesor_id')
                            ->relationship('asesor', 'nama')
                            ->required(),
                    ]),
                Fieldset::make('Admin')
                    ->hidden(auth()->user()->isAsesor)
                    ->schema([
                        FileUpload::make('ttd_admin')
                            ->label('Tanda tangan Admin')
                            ->directory('ttd/asesmen/admin')
                            ->image()
                            ->maxSize(1024),
                        Forms\Components\Select::make('admin_id')
                            ->relationship(
                                name: 'admin',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('type', UserType::ADMIN),
                                )
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asesi.nama')
                    ->sortable()
                    ->label('Asesi  / No. Reg')
                    ->description(fn (Asesmen $record): string => $record->asesi->no_reg ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asesi.sekolah.nama')
                    ->label('Asal Sekolah')
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: true,
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('skema.nama')
                    ->label('Skema')
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('asesor.nama')
                    ->label('Asesor')
                    ->sortable()
                    ->description(fn (Asesmen $record): string => $record->asesor->nomor_registrasi ?? '-')
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: false,
                    ),
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin')
                    ->sortable()
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: true,
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: false,
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(AsesmenStatus::class),
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
                SelectFilter::make('periode_id')
                    ->label('Periode')
                    ->searchable()
                    ->preload()
                    ->options(Periode::query()->pluck('nama', 'id')),
                SelectFilter::make('asesor_id')
                    ->label('Asesor')
                    ->searchable()
                    ->preload()
                    ->options(Asesor::query()->pluck('nama', 'id')),

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Terima Permohonan')
                        ->icon('heroicon-m-check-circle')
                        // ->requiresConfirmation()
                        ->action(function (Collection $records, array $data): void {
                            try {
                                DB::beginTransaction();
                                foreach ($records as $record) {
                                    $ttd = Signature::upload('ttd/asesmen/admin/', $data['ttd_admin'], $record->id);
                                    $record->update([
                                        'admin_id' => auth()->id(),
                                        'ttd_admin' => $ttd
                                    ]);
                                    if ($record->status === AsesmenStatus::REGISTRASI) {
                                        $record->update(['status' => AsesmenStatus::ASESMEN_MANDIRI]);
                                    }
                                }
                                DB::commit();
                                Notification::make()->title('Permohonan Sertifikat Kompetensi diterima!')->success()->send();
                            } catch (\Throwable $th) {
                                Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                                report($th->getMessage());
                                DB::rollBack();
                            }
                        })
                        ->form([
                            Placeholder::make('admin')
                                ->label('Admin (anda)')
                                ->content(auth()->user()->name)
                                ->inlineLabel(),
                            SignaturePad::make('ttd_admin')
                                ->penColor('black')
                                ->penColorOnDark('black')
                                ->inlineLabel()
                                ->label('Tanda tangan Admin'),
                        ])
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('Pilih Asesor')
                        ->icon('heroicon-m-user')
                        ->action(function (Collection $records, array $data): void {
                            try {
                                foreach ($records as $record) {
                                    if ($data['status']) {
                                        $record->status = AsesmenStatus::ASESMEN_MANDIRI;
                                    }
                                    if ($data['asesor_id'] != $record->asesor_id) {
                                        $record->ttd_asesor = null;
                                    }
                                    $record->asesor_id = $data['asesor_id'];
                                    $record->save();
                                }
                                Notification::make()->title('Asesor Dipilih!')->success()->send();
                            } catch (\Throwable $th) {
                                Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                                report($th->getMessage());
                            }

                        })
                        ->form([
                            Forms\Components\Select::make('asesor_id')
                                ->label('Pilih Asesor')
                                ->options(Asesor::query()->pluck('nama', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\Checkbox::make('status')
                                ->label('Reset Status Asesmen')
                                ->default(true),
                        ])
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(2);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BuktiRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AsesmenResource\Widgets\AsesmenOverview::class,
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            AsesmenResource\Pages\EditAsesmen::class,
            AsesmenResource\Pages\AsesmenMandiriPage::class,
            AsesmenResource\Pages\PersetujuanAsesmenDanKerahasiaanPage::class,
            AsesmenResource\Pages\CeklisObservasiAktivitasPage::class,
            AsesmenResource\Pages\PertanyaanObservasiPendukungPage::class,
            AsesmenResource\Pages\PertanyaanTertulisPilihanGandaPage::class,
            AsesmenResource\Pages\PertanyaanTertulisEsaiPage::class,
            AsesmenResource\Pages\RekamanAsesmenPage::class,
            AsesmenResource\Pages\UmpanBalikDanCatatanAsesmenPage::class,
            AsesmenResource\Pages\BandingAsesmenPage::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsesmens::route('/'),
            'create' => Pages\CreateAsesmen::route('/create'),
            'edit' => Pages\EditAsesmen::route('/{record}/edit'),
            'asesmen-mandiri' => Pages\AsesmenMandiriPage::route('/{record}/asesmen-mandiri'),
            'persetujuan-asesmen-dan-kerahasiaan' => Pages\PersetujuanAsesmenDanKerahasiaanPage::route('/{record}/persetujuan-asesmen-dan-kerahasiaan'),
            'ceklis-observasi-aktivitas' => Pages\CeklisObservasiAktivitasPage::route('/{record}/ceklis-observasi-aktivitas'),
            'pertanyaan-observasi-pendukung' => Pages\PertanyaanObservasiPendukungPage::route('/{record}/pertanyaan-observasi-pendukung'),
            'pertanyaan-tertulis-pilihan-ganda' => Pages\PertanyaanTertulisPilihanGandaPage::route('/{record}/pertanyaan-tertulis-pilihan-ganda'),
            'pertanyaan-tertulis-esai' => Pages\PertanyaanTertulisEsaiPage::route('/{record}/pertanyaan-tertulis-esai'),
            'rekaman' => Pages\RekamanAsesmenPage::route('/{record}/rekaman'),
            'umpan-balik-dan-catatan' => Pages\UmpanBalikDanCatatanAsesmenPage::route('/{record}/umpan-balik-dan-catatan'),
            'banding' => Pages\BandingAsesmenPage::route('/{record}/banding'),
        ];
    }
}
