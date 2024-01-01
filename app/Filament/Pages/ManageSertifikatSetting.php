<?php

namespace App\Filament\Pages;

use App\Settings\SertifikatSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSertifikatSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Sertifikat';

    protected static ?string $navigationGroup = 'Sistem';

    protected static string $settings = SertifikatSetting::class;

    protected static ?int $navigationSort = 15;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->isAdmin, 403);
        parent::mount();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lembaga')
                    ->label('Nama Lembaga')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama_lembaga_en')
                    ->label('Nama Lembaga (Bahasa Inggris)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('ketua_lsp')
                    ->label('Ketua LSP')
                    ->required(),
                Forms\Components\TextInput::make('ketua_bidang_sertifikasi')
                    ->label('Ketua Bidang Sertifikasi')
                    ->required(),
                Forms\Components\TextInput::make('masa_berlaku')
                    ->label('Masa Berlaku Sertifikat')
                    ->required(),
                Forms\Components\TextInput::make('masa_berlaku_en')
                    ->label('Masa Berlaku Sertifikat (Bahasa Inggris)')
                    ->required(),
                Forms\Components\FileUpload::make('logo')
                    ->label('logo')
                    ->directory('logo'),
                Forms\Components\TextInput::make('kode')
                    ->label('Kode')
                    ->required()
            ]);
    }
}
