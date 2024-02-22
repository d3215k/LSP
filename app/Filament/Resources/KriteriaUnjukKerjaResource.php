<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaUnjukKerjaResource\Pages;
use App\Filament\Resources\KriteriaUnjukKerjaResource\RelationManagers;
use App\Models\Scopes\AktifScope;
use App\Models\Skema;
use App\Models\Skema\KriteriaUnjukKerja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('elemen_id')
                    ->required()
                    ->relationship(name: 'elemen', titleAttribute: 'nama')
                    ->searchable()
                    ->preload(),
                Forms\Components\Textarea::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'DESC')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('elemen.unit.skema.nama')
                    ->label('Skema / Elemen')
                    ->description(fn (KriteriaUnjukKerja $record): string => $record->elemen->nama ?? '-')
                    ->wrap(),
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
                                'elemen',
                                fn (Builder $query) => $query->whereHas(
                                    'unit',
                                    fn (Builder $query) => $query->whereHas(
                                        'skema',
                                        fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                                    )
                                )
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
            'index' => Pages\ListKriteriaUnjukKerjas::route('/'),
            'create' => Pages\CreateKriteriaUnjukKerja::route('/create'),
            'edit' => Pages\EditKriteriaUnjukKerja::route('/{record}/edit'),
        ];
    }
}
