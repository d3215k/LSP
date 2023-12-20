<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaUnjukKerjaResource\Pages;
use App\Filament\Resources\KriteriaUnjukKerjaResource\RelationManagers;
use App\Models\KriteriaUnjukKerja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KriteriaUnjukKerjaResource extends Resource
{
    protected static ?string $model = KriteriaUnjukKerja::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Skema';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('elemen_id')
                    ->required()
                    ->relationship(name: 'elemen', titleAttribute: 'nama'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('elemen_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListKriteriaUnjukKerjas::route('/'),
            'create' => Pages\CreateKriteriaUnjukKerja::route('/create'),
            'edit' => Pages\EditKriteriaUnjukKerja::route('/{record}/edit'),
        ];
    }
}
