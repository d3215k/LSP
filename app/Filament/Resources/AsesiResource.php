<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelamin;
use App\Filament\Resources\AsesiResource\Pages;
use App\Filament\Resources\AsesiResource\RelationManagers;
use App\Models\Asesi;
use App\Models\KompetensiKeahlian;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsesiResource extends Resource
{
    protected static ?string $model = Asesi::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kompetensi_keahlian_id')
                    ->relationship('kompetensiKeahlian', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('sekolah_id')
                    ->relationship(
                        name: 'sekolah',
                        titleAttribute: 'nama',
                        modifyQueryUsing: fn ($query) => $query->withoutGlobalScopes()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('no_reg')
                    ->label('No. Registrasi')
                    ->hiddenOn('create')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->label('No. KTP/NIK/Paspor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\ToggleButtons::make('jk')
                    ->label('L/P')
                    ->inline()
                    ->options(JenisKelamin::class),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_rumah')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_telepon_rumah')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_telepon_hp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Toggle::make('aktif')
                    ->required()
                    ->inline(false)
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama / No. Reg')
                    ->description(fn (Asesi $record): string => $record->no_reg ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kompetensiKeahlian.nama')
                    ->label('Kompetensi Keahlian / Sekolah')
                    ->description(fn (Asesi $record): string => $record->sekolah->nama ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asesmen_count')
                    ->counts('asesmen')
                    ->label('Asesmen'),
            ])
            ->filters([
                SelectFilter::make('Asal Sekolah')
                    ->options(
                        fn() => Sekolah::query()
                            ->withoutGlobalScopes()
                            ->pluck('nama', 'id')->toArray(),
                    )
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->where('sekolah_id', '=', (int) $data['value']);
                        }
                    })
                    ->columnSpan(1),
                SelectFilter::make('Kompetensi Keahlian')
                    ->options(
                        fn() => KompetensiKeahlian::query()
                            ->withoutGlobalScopes()
                            ->pluck('nama', 'id')->toArray(),
                    )
                    ->preload()
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->where('kompetensi_keahlian_id', '=', (int) $data['value']);
                        }
                    })
                    ->columnSpan(1),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filtersLayout(
                FiltersLayout::AboveContent
            )
            ->filtersFormColumns(2);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AsesmenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsesis::route('/'),
            'create' => Pages\CreateAsesi::route('/create'),
            'edit' => Pages\EditAsesi::route('/{record}/edit'),
        ];
    }
}
