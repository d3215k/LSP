<?php

namespace App\Filament\Resources\UnitResource\RelationManagers;

use App\Models\Scopes\AktifScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PertanyaanTertulisEsaiRelationManager extends RelationManager
{
    protected static string $relationship = 'pertanyaanTertulisEsai';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('pertanyaan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('jawaban')
                    ->required()
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
                    ->html(),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit'),
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
