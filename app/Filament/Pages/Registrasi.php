<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Registrasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.registrasi';

    protected static ?string $navigationGroup = 'Uji Kompetensi';

    public string $activeTab = 'tab1';

}
