<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElemenResource\Pages;
use App\Filament\Resources\ElemenResource\RelationManagers;
use App\Models\Scopes\AktifScope;
use App\Models\Skema;
use App\Models\Skema\Elemen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ElemenResource extends Resource
{
    protected static ?string $model = Elemen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Skema';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

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
                Forms\Components\Select::make('unit_id')
                    ->required()
                    ->relationship(name: 'unit', titleAttribute: 'judul')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('benchmark')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.skema.nama')
                    ->label('Skema / Unit')
                    ->description(fn (Elemen $record): string => $record->unit->judul ?? '-')
                    ->wrap(),
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
                                'unit',
                                fn (Builder $query) => $query->whereHas(
                                    'skema',
                                    fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
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
            RelationManagers\KukRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListElemens::route('/'),
            'create' => Pages\CreateElemen::route('/create'),
            'edit' => Pages\EditElemen::route('/{record}/edit'),
        ];
    }
}
