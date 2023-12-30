<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikatResource\Pages;
use App\Filament\Resources\SertifikatResource\RelationManagers;
use App\Models\Asesi;
use App\Models\Sertifikat;
use App\Models\Skema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SertifikatResource extends Resource
{
    protected static ?string $model = Sertifikat::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_sertifikat')
                    ->default('LSP01 199 69988521 ' . random_int(1111, 9999) . ' ' . date("Y"))
                    ->dehydrated()
                    ->required()
                    ->maxLength(32)
                    ->unique(Sertifikat::class, 'no_sertifikat', ignoreRecord: true),
                Forms\Components\Select::make('pemilik')
                    ->label('Nama')
                    ->options(Asesi::all()->pluck('nama', 'nama'))
                    ->required()
                    ->searchable(),
                // Forms\Components\Select::make('skema')
                //     ->label('Skema')
                //     ->options(Skema::all()->pluck('nama', 'nama'))
                //     ->required()
                //     ->searchable(),
                Forms\Components\TextInput::make('tempat_terbit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_terbit')
                    ->required(),
                Forms\Components\TextInput::make('masa_berlaku')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_sertifikat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pemilik')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Cetak Sertifikat')
                    ->button()
                    ->icon('heroicon-m-printer')
                    ->url(fn (Sertifikat $record): string => route('generate.sertifikat', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Cetak Sertifikat')
                        ->requiresConfirmation()
                        ->icon('heroicon-m-printer')
                        ->action(fn (Collection $records) => $records->each->print())
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
            'index' => Pages\ListSertifikats::route('/'),
            'create' => Pages\CreateSertifikat::route('/create'),
            'edit' => Pages\EditSertifikat::route('/{record}/edit'),
        ];
    }
}
