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

    protected static ?int $navigationSort = 11;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Setting')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Detail Profile LSP')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama LSP')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('jenis')
                                    ->label('Jenis')
                                    ->required(),
                                Forms\Components\TextInput::make('sub_jenis')
                                    ->label('Sub Jenis')
                                    ->required(),
                                Forms\Components\TextInput::make('no_akta')
                                    ->label('No Akta')
                                    ->required(),
                                Forms\Components\TextInput::make('tanggal_berdiri')
                                    ->label('Tanggal Berdiri')
                                    ->required(),
                                Forms\Components\TextInput::make('no_sertifikat_lisensi')
                                    ->label('No Sertifikat Lisensi')
                                    ->required(),
                                Forms\Components\TextInput::make('no_sk_lsp_terakhir')
                                    ->label('No SK LSP Terakhir')
                                    ->required(),
                                Forms\Components\TextInput::make('berlaku_mulai')
                                    ->label('Berlaku Mulai')
                                    ->required(),
                                Forms\Components\TextInput::make('expired')
                                    ->label('Expired')
                                    ->required(),
                                ]),

                                Forms\Components\Tabs\Tab::make('Alamat LSP')
                                ->schema([
                                    Forms\Components\TextInput::make('provinsi')
                                        ->label('Provinsi')
                                        ->required(),
                                    Forms\Components\TextInput::make('kota_kabupaten')
                                        ->label('Kota Kabupaten')
                                        ->required(),
                                    Forms\Components\TextInput::make('alamat')
                                        ->label('Alamat')
                                        ->required(),
                                    Forms\Components\TextInput::make('koordinat_lokasi')
                                        ->label('Koordinat Lokasi')
                                        ->required(),
                                    Forms\Components\TextInput::make('no_telepon_kantor')
                                        ->label('No Telepon Kantor')
                                        ->required(),
                                    Forms\Components\TextInput::make('no_handphone_admin')
                                        ->label('No Handphone Admin')
                                        ->required(),
                                    Forms\Components\TextInput::make('email')
                                        ->label('Email')
                                        ->required(),
                                    Forms\Components\TextInput::make('website')
                                        ->label('Website')
                                        ->required(),
                                ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
