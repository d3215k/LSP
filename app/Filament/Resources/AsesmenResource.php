<?php

namespace App\Filament\Resources;

use App\Enums\AsesmenStatus;
use App\Enums\TujuanAsesmen;
use App\Filament\Resources\AsesmenResource\Pages;
use App\Filament\Resources\AsesmenResource\RelationManagers;
use App\Models\Asesmen;
use App\Models\Asesor;
use App\Models\Periode;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class AsesmenResource extends Resource
{
    protected static ?string $model = Asesmen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 1;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('skema_id')
                    ->relationship('skema', 'nama')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('periode_id')
                    ->relationship('periode', 'nama')
                    ->options(Periode::all()->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\Select::make('asesor_id')
                    ->relationship('asesor', 'nama')
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
                Fieldset::make('Tanda tangan')
                    ->schema([
                        FileUpload::make('ttd_asesi')
                            ->label('Asesi')
                            ->directory('ttd/asesmen/asesi')
                            ->image()
                            ->maxSize(1024),
                        FileUpload::make('ttd_asesor')
                            ->label('Asesor')
                            ->directory('ttd/asesmen/asesor')
                            ->image()
                            ->maxSize(1024),
                    ])
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
                    Tables\Actions\BulkAction::make('Terima Pendaftaran')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            try {
                                DB::beginTransaction();
                                foreach ($records as $record) {
                                    if ($record->status === AsesmenStatus::REGISTRASI) {
                                        $record->update(['status' => AsesmenStatus::ASESMEN_MANDIRI]);
                                    }
                                }
                                DB::commit();
                                Notification::make()->title('Pengajuan diterima!')->success()->send();
                            } catch (\Throwable $th) {
                                Notification::make()->title('Whoops!')->body('Ada yang salah')->danger()->send();
                                report($th->getMessage());
                                DB::rollBack();
                            }

                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('Pilih Asesor')
                        ->icon('heroicon-m-user')
                        ->action(function (Collection $records, array $data): void {
                            try {
                                foreach ($records as $record) {
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
                        ])
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
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
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsesmens::route('/'),
            'create' => Pages\CreateAsesmen::route('/create'),
            'edit' => Pages\EditAsesmen::route('/{record}/edit'),
        ];
    }
}
