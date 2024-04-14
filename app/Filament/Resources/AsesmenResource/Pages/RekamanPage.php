<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use Filament\Resources\Pages\Page;

class RekamanPage extends Page
{
    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.rekaman-page';
}
