<?php

namespace App\Filament\Resources\SkemaResource\RelationManagers;

use App\Enums\JenisTempatUjiKompetensi;
use App\Models\Scopes\AktifScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TempatUjiKompetensiRelationManager extends RelationManager
{
    protected static string $relationship = 'tempatUjiKompetensi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis')
                    ->options(JenisTempatUjiKompetensi::class),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScope(AktifScope::class))
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('skema');
    }
}
