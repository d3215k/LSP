<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodeResource\Pages;
use App\Filament\Resources\PeriodeResource\RelationManagers;
use App\Models\Periode;
use App\Models\Scopes\AktifScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodeResource extends Resource
{
    protected static ?string $model = Periode::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScope(AktifScope::class)
            ->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('skema_id')
                    ->required()
                    ->relationship('skema', 'nama')
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('buka')
                    ->required(),
                Forms\Components\DatePicker::make('tutup')
                    ->required(),
                Forms\Components\TextInput::make('lokasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktif')
                    ->inline(false)
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('skema.nama')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('buka')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutup')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asesmen_count')
                    ->label('Jumlah Asesmen Terdaftar')
                    ->counts('asesmen'),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
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
            'index' => Pages\ListPeriodes::route('/'),
            'create' => Pages\CreatePeriode::route('/create'),
            'edit' => Pages\EditPeriode::route('/{record}/edit'),
        ];
    }
}
