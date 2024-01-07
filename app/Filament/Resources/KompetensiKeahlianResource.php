<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KompetensiKeahlianResource\Pages;
use App\Filament\Resources\KompetensiKeahlianResource\RelationManagers;
use App\Models\KompetensiKeahlian;
use App\Models\Scopes\AktifScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KompetensiKeahlianResource extends Resource
{
    protected static ?string $model = KompetensiKeahlian::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 10;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reg')
                    ->label('Kode di Registrasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sertifikat')
                    ->label('Kode di Sertifikat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SekolahRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKompetensiKeahlians::route('/'),
            'create' => Pages\CreateKompetensiKeahlian::route('/create'),
            'edit' => Pages\EditKompetensiKeahlian::route('/{record}/edit'),
        ];
    }
}
