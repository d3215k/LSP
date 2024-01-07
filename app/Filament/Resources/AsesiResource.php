<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsesiResource\Pages;
use App\Filament\Resources\AsesiResource\RelationManagers;
use App\Models\Asesi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsesiResource extends Resource
{
    protected static ?string $model = Asesi::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kompetensi')
                    ->relationship('kompetensiKeahlian', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('jk')
                    ->maxLength(1),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAsesis::route('/'),
            'create' => Pages\CreateAsesi::route('/create'),
            'edit' => Pages\EditAsesi::route('/{record}/edit'),
        ];
    }
}
