<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Scopes\AktifScope;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?string $modelLabel = 'Akses Pengguna';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScope(AktifScope::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('type')
                    ->label('Role')
                    ->options(UserType::class),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Role')
                    ->options(UserType::class),
            ])
            ->actions([
                Impersonate::make(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\Action::make('reset')
                    ->icon('heroicon-m-lock-open')
                    ->color('danger')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading(
                        fn (User $record) => 'Reset Password ' . $record->name
                    )
                    ->modalDescription('Setelah direset, password menjadi smkn1cbd*')
                    ->action(fn (User $record) => $record->resetPassword()),
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
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UserResource\Widgets\UserStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
