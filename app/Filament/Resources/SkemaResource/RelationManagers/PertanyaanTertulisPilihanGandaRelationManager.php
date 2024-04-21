<?php

namespace App\Filament\Resources\SkemaResource\RelationManagers;

use App\Models\Scopes\AktifScope;
use App\Models\Skema\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PertanyaanTertulisPilihanGandaRelationManager extends RelationManager
{
    protected static string $relationship = 'pertanyaanTertulisPilihanGanda';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->label('Unit')
                    ->options(
                        Unit::where('skema_id', $this->getOwnerRecord()->id)
                            ->pluck('judul', 'id')
                    )
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('pertanyaan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('pilihanJawaban')
                    ->relationship()
                    ->schema([
                        Forms\Components\Toggle::make('kompeten')
                            ->inline(false)
                            ->default(false),
                        Forms\Components\RichEditor::make('jawaban')
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->orderColumn('sort')
                    ->columns(2)
                    ->defaultItems(5)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('aktif')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(AktifScope::class))
            ->recordTitleAttribute('pertanyaan')
            ->columns([
                Tables\Columns\TextColumn::make('pertanyaan')
                    ->html()
                    ->wrap(),
                Tables\Columns\ToggleColumn::make('aktif')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->closeModalByClickingAway(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit')
                    ->closeModalByClickingAway(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
    }
}
