<?php

namespace App\Filament\Resources\Asesmen;

use App\Enums\AsesmenTertulisStatus;
use App\Filament\Clusters\Asesmen;
use App\Filament\Resources\Asesmen\TertulisPilihanGandaResource\Pages;
use App\Filament\Resources\Asesmen\TertulisPilihanGandaResource\RelationManagers;
use App\Models\Asesmen\TertulisPilihanGanda;
use App\Models\Asesor;
use App\Models\Periode;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TertulisPilihanGandaResource extends Resource
{
    protected static ?string $model = TertulisPilihanGanda::class;

    protected static ?string $cluster = Asesmen::class;

    protected static ?string $modelLabel = "Asesmen Tertulis Pilihan Ganda";

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'FR.IA.05';

    protected static ?int $navigationSort = 5;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return auth()->user()->isAdmin;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn (TertulisPilihanGanda $record): string => route('filament.app.asesmen.resources.asesmens.pertanyaan-tertulis-pilihan-ganda', $record->asesmen),
            )
            ->columns([
                Tables\Columns\TextColumn::make('asesmen.asesi.nama')
                    ->sortable()
                    ->label('Asesi  / No. Reg')
                    ->description(fn (TertulisPilihanGanda $record): string => $record->asesmen->asesi->no_reg ?? '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asesmen.asesi.sekolah.nama')
                    ->label('Asal Sekolah')
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: true,
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('asesmen.skema.nama')
                    ->label('Skema')
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('asesmen.asesor.nama')
                    ->label('Asesor')
                    ->sortable()
                    ->description(fn (TertulisPilihanGanda $record): string => $record->asesmen->asesor->nomor_registrasi ?? '-')
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: true,
                    ),
                Tables\Columns\TextColumn::make('tanggal_asesmen')
                    ->date()
                    ->sortable()
                    ->toggleable(
                        condition: true,
                        isToggledHiddenByDefault: true,
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kompeten_count')
                    ->counts('kompeten')
                    ->label('K'),
                Tables\Columns\TextColumn::make('belum_kompeten_count')
                    ->counts('belumKompeten')
                    ->color('danger')
                    ->label('BK'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(AsesmenTertulisStatus::class),
                SelectFilter::make('Asal Sekolah')
                    ->options(
                        fn() => Sekolah::query()->withoutGlobalScopes()->pluck('nama', 'id')->toArray(),
                    )
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas(
                                'asesmen',
                                fn (Builder $query) => $query->whereHas(
                                    'asesi',
                                    fn (Builder $query) => $query->whereHas(
                                        'sekolah',
                                        fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                                    )
                                )
                            );
                        }
                    }),
                SelectFilter::make('periode_id')
                    ->label('Periode')
                    ->searchable()
                    ->preload()
                    ->options(Periode::query()->pluck('nama', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas(
                                'asesmen',
                                fn (Builder $query) => $query->where('periode_id', '=', (int) $data['value'])
                            );
                        }
                    }),
                SelectFilter::make('asesor_id')
                    ->label('Asesor')
                    ->searchable()
                    ->preload()
                    ->options(Asesor::query()->pluck('nama', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas(
                                'asesmen',
                                fn (Builder $query) => $query->where('asesor_id', '=', (int) $data['value'])
                            );
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('Reset Waktu')
                    ->icon('heroicon-m-clock')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->action(fn(TertulisPilihanGanda $record) => $record->resetWaktu())
                    ->hidden(fn (TertulisPilihanGanda $record): bool => $record->status === \App\Enums\AsesmenTertulisStatus::SELESAI),
                Tables\Actions\Action::make('Selesai')
                    ->icon('heroicon-m-x-circle')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->action(fn(TertulisPilihanGanda $record) => $record->forceFinish())
                    ->hidden(fn (TertulisPilihanGanda $record): bool => $record->status === \App\Enums\AsesmenTertulisStatus::SELESAI),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Lihat')
                        ->icon('heroicon-m-document-text')
                        ->url(fn (TertulisPilihanGanda $record): string => route('filament.app.asesmen.resources.asesmens.pertanyaan-tertulis-pilihan-ganda', $record->asesmen)),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(2);
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
            'index' => Pages\ListTertulisPilihanGandas::route('/'),
        ];
    }
}
