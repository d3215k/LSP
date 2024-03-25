<?php

namespace App\Filament\Resources;

use App\Enums\JenisSkema;
use App\Filament\Resources\SkemaResource\Pages;
use App\Filament\Resources\SkemaResource\RelationManagers;
use App\Models\Scopes\AktifScope;
use App\Models\Skema;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkemaResource extends Resource
{
    protected static ?string $model = Skema::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 9;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest()
            ->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Skema')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Detail Profile Skema')
                            ->schema([
                                // Forms\Components\TextInput::make('mode')
                                //     ->required()
                                //     ->maxLength(255),
                                Forms\Components\Textarea::make('nama')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\ToggleButtons::make('jenis')
                                    ->required()
                                    ->inline()
                                    ->options(JenisSkema::class),
                                Forms\Components\TextInput::make('kode')
                                    ->required()
                                    ->maxLength(255),
                                // Forms\Components\DatePicker::make('tanggal_penetapan'),
                                // Forms\Components\TextInput::make('no_urut')
                                //     ->maxLength(255),
                                // Forms\Components\TextInput::make('no_penetapan')
                                //     ->maxLength(255),
                                // Forms\Components\TextInput::make('biaya_assesmen')
                                //     ->numeric(),
                                Forms\Components\TextInput::make('kompetensi_keahlian')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\TextInput::make('kompetensi_keahlian_en')
                                    ->label('Kompetensi Keahlian (EN)')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\TextInput::make('level_kkni')
                                    ->label('Level KKNI')
                                    ->required()
                                    ->maxLength(3),
                                Forms\Components\TextInput::make('bidang')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\TextInput::make('bidang_en')
                                    ->label('Bidang (EN)')
                                    ->required()
                                    ->maxLength(128),
                                Forms\Components\FileUpload::make('file')
                                    ->directory('skema')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(1024),
                                Forms\Components\FileUpload::make('cover')
                                    ->directory('skema')
                                    ->image()
                                    ->maxSize(1024),
                                Forms\Components\Toggle::make('aktif')
                                    ->inline(false)
                                    ->default(true)
                                    ->required(),
                            ]),
                        // Forms\Components\Tabs\Tab::make('Sub Sektor dan Bidang')
                        //     ->schema([
                        //         Forms\Components\TextInput::make('sub_sektor')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('bidang')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('sub_bidang')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('sub_bidang_mea')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('kbji')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('sub_kbji')
                        //             ->maxLength(255),
                        //         Forms\Components\TextInput::make('sub_bidang_kbji')
                        //             ->maxLength(255),
                        //     ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_count')
                    ->label('Unit')
                    ->counts('unit'),
                Tables\Columns\TextColumn::make('elemen_count')
                    ->label('Elemen')
                    ->counts('elemen'),
                Tables\Columns\TextColumn::make('sertifikat_count')
                    ->label('Sertifikat')
                    ->counts('sertifikat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UnitsRelationManager::class,
            RelationManagers\PersyaratanRelationManager::class,
            RelationManagers\TempatUjiKompetensiRelationManager::class,
            RelationManagers\AsesorRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkemas::route('/'),
            'create' => Pages\CreateSkema::route('/create'),
            'edit' => Pages\EditSkema::route('/{record}/edit'),
        ];
    }
}
