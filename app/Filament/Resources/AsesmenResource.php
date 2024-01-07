<?php

namespace App\Filament\Resources;

use App\Enums\TujuanAsesmen;
use App\Filament\Resources\AsesmenResource\Pages;
use App\Filament\Resources\AsesmenResource\RelationManagers;
use App\Models\Asesmen;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsesmenResource extends Resource
{
    protected static ?string $model = Asesmen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 1;

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asesi.nama')
                    ->label('Asesi  / No. Reg')
                    ->description(fn (Asesmen $record): string => $record->asesi->no_reg ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('skema.nama')
                    ->label('Skema')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BuktiRelationManager::class,
        ];
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
