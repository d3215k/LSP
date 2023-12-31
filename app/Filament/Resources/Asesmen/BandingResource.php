<?php

namespace App\Filament\Resources\Asesmen;

use App\Filament\Resources\Asesmen\BandingResource\Pages;
use App\Filament\Resources\Asesmen\BandingResource\RelationManagers;
use App\Models\Asesmen\Banding;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BandingResource extends Resource
{
    protected static ?string $model = Banding::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Asesmen';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asesmen_id')
                    ->relationship('asesmen.asesi', 'nama')
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Placeholder::make('Telah Dijelaskan')
                    ->label('Apakah Proses Banding telah dijelaskan kepada Anda?')
                    ->content(fn (Banding $record): string => $record->telah_dijelaskan ? 'YA' : 'TIDAK'),
                Forms\Components\Placeholder::make('telah_diskusi')
                    ->label('Apakah Anda telah mendiskusikan Banding dengan Asesor?')
                    ->content(fn (Banding $record): string => $record->telah_diskusi ? 'YA' : 'TIDAK'),
                Forms\Components\Placeholder::make('melibatkan')
                    ->label('Apakah Anda mau melibatkan “orang lain” membantu Anda dalam Proses Banding?')
                    ->content(fn (Banding $record): string => $record->melibatkan ? 'YA' : 'TIDAK'),
                Forms\Components\Placeholder::make('alasan')
                    ->label('Banding ini diajukan atas alasan sebagai berikut :')
                    ->content(fn (Banding $record): string => $record->alasan),
                Forms\Components\Placeholder::make('tanggal')
                    ->label('Tanggal')
                    ->content(fn (Banding $record): string => $record->tanggal),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asesmen.asesi.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alasan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBandings::route('/'),
            'create' => Pages\CreateBanding::route('/create'),
            'edit' => Pages\EditBanding::route('/{record}/edit'),
        ];
    }
}
