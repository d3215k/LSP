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
                Forms\Components\Select::make('pemilik')
                    ->label('Nama')
                    ->options(Asesi::all()->pluck('nama', 'nama'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('no_sertifikat')
                    ->required()
                    ->maxLength(32)
                    ->unique(Sertifikat::class, 'no_sertifikat', ignoreRecord: true),
                Forms\Components\TextInput::make('no_reg')
                    ->required()
                    ->maxLength(32),
                Forms\Components\TextInput::make('no_blanko')
                    ->maxLength(32),
                Forms\Components\TextInput::make('bidang')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('bidang_en')
                    ->label('Bidang (EN)')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('kompetensi')
                    ->required()
                    ->maxLength(128),
                Forms\Components\TextInput::make('kompetensi_en')
                    ->label('Kompetensi (EN)')
                    ->required()
                    ->maxLength(128),
                Forms\Components\DatePicker::make('tanggal_terbit')
                    ->required(),
                Forms\Components\Section::make('Daftar Unit')
                    ->schema([
                        Forms\Components\Repeater::make('unit')
                            ->schema([
                                Forms\Components\TextInput::make('kode')
                                    ->required(),
                                Forms\Components\TextInput::make('judul')
                                    ->required(),
                                Forms\Components\TextInput::make('judul_en')
                                    ->label('Judul (EN)')
                                    ->required(),
                            ])->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_sertifikat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kompetensi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pemilik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kompetensi')
                    ->options(Sertifikat::distinct()->pluck('kompetensi', 'kompetensi'))
            ])
            ->actions([
                Tables\Actions\Action::make('Cetak Sertifikat')
                    ->button()
                    ->icon('heroicon-m-printer')
                    ->url(fn (Sertifikat $record): string => route('generate.sertifikat', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    // Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                //
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
