<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikatResource\Pages;
use App\Filament\Resources\SertifikatResource\RelationManagers;
use App\Models\Asesi;
use App\Models\Sertifikat;
use App\Models\Skema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SertifikatResource extends Resource
{
    protected static ?string $model = Sertifikat::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_sertifikat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('nama')
                    ->label('Nama')
                    ->options(Asesi::all()->pluck('nama', 'nama'))
                    ->searchable(),
                Forms\Components\Select::make('skema')
                    ->label('Skema')
                    ->options(Skema::all()->pluck('judul', 'judul'))
                    ->searchable(),
                Forms\Components\TextInput::make('tempat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TextInput::make('masa_berlaku')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_sertifikat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('skema')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('masa_berlaku')
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
            'index' => Pages\ListSertifikats::route('/'),
            'create' => Pages\CreateSertifikat::route('/create'),
            'edit' => Pages\EditSertifikat::route('/{record}/edit'),
        ];
    }
}
