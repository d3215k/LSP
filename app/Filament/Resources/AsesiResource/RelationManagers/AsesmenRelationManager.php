<?php

namespace App\Filament\Resources\AsesiResource\RelationManagers;

use App\Models\Asesmen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsesmenRelationManager extends RelationManager
{
    protected static string $relationship = 'asesmen';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('skema.nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('skema.nama')
            ->recordUrl(
                fn (Asesmen $record): string => route('filament.app.resources.asesmens.edit', $record),
            )
            ->columns([
                Tables\Columns\TextColumn::make('skema.nama')
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
