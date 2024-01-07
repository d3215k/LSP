<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsesorResource\Pages;
use App\Filament\Resources\AsesorResource\RelationManagers;
use App\Models\Asesor;
use App\Models\Scopes\AktifScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsesorResource extends Resource
{
    protected static ?string $model = Asesor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_registrasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(32),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('jk')
                    ->maxLength(1),
                Forms\Components\TextInput::make('pendidikan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_ktp_provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_ktp_kota_kabupaten')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_ktp_lengkap')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_tempat_tinggal_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_tempat_tinggal_provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_tempat_tinggal_kota_kabupaten')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_tempat_tinggal_lengkap')
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_registrasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('aktif'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsesors::route('/'),
            'create' => Pages\CreateAsesor::route('/create'),
            'edit' => Pages\EditAsesor::route('/{record}/edit'),
        ];
    }
}
