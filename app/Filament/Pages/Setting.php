<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class Setting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Profil LSP';

    protected static ?string $navigationGroup = 'Admin';

    protected static string $settings = GeneralSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama LSP')
                    ->required(),
                Forms\Components\TextInput::make('jenis')
                    ->label('jenis')
                    ->required(),
                Forms\Components\TextInput::make('sub_jenis')
                    ->label('sub_jenis')
                    ->required(),
                Forms\Components\TextInput::make('no_akta')
                    ->label('no_akta')
                    ->required(),
                Forms\Components\TextInput::make('tanggal_berdiri')
                    ->label('tanggal_berdiri')
                    ->required(),
                Forms\Components\TextInput::make('no_sertifikat_lisensi')
                    ->label('no_sertifikat_lisensi')
                    ->required(),
                Forms\Components\TextInput::make('no_sk_lsp_terakhir')
                    ->label('no_sk_lsp_terakhir')
                    ->required(),
                Forms\Components\TextInput::make('berlaku_mulai')
                    ->label('berlaku_mulai')
                    ->required(),
                Forms\Components\TextInput::make('expired')
                    ->label('expired')
                    ->required(),
                Forms\Components\TextInput::make('provinsi')
                    ->label('provinsi')
                    ->required(),
                Forms\Components\TextInput::make('kota_kabupaten')
                    ->label('kota_kabupaten')
                    ->required(),
                Forms\Components\TextInput::make('alamat')
                    ->label('alamat')
                    ->required(),
                Forms\Components\TextInput::make('koordinat_lokasi')
                    ->label('koordinat_lokasi')
                    ->required(),
                Forms\Components\TextInput::make('no_telepon_kantor')
                    ->label('no_telepon_kantor')
                    ->required(),
                Forms\Components\TextInput::make('no_handphone_admin')
                    ->label('no_handphone_admin')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('email')
                    ->required(),
                Forms\Components\TextInput::make('website')
                    ->label('website')
                    ->required(),
            ]);
    }
}
