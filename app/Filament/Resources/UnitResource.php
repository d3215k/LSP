<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Scopes\AktifScope;
use App\Models\Skema;
use App\Models\Skema\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Skema';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('skema_id')
                    ->required()
                    ->relationship(name: 'skema', titleAttribute: 'nama'),
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('judul_en')
                    ->label('Judul (EN)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('aktif')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'DESC')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('skema.nama')
                    ->label('Skema')
                    ->wrap(),
                Tables\Columns\TextColumn::make('elemen_count')
                    ->label('Elemen')
                    ->counts('elemen'),
                Tables\Columns\TextColumn::make('kuk_count')
                    ->label('KUK')
                    ->counts('kuk'),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->filters([
                SelectFilter::make('skema')
                    ->label('Skema')
                    ->options(
                        fn () => Skema::query()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value']))
                        {
                            $query->whereHas(
                                'skema',
                                fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                            );
                        }
                    })
                    ->searchable()
                    ->preload()
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
            RelationManagers\ElementsRelationManager::class,
            RelationManagers\PertanyaanObservasiPendukungRelationManager::class,
            RelationManagers\PertanyaanTertulisEsaiRelationManager::class,
            RelationManagers\PertanyaanTertulisPilihanGandaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
