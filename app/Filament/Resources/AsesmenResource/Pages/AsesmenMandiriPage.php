<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class AsesmenMandiriPage extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.asesmen-mandiri-page';

    protected static ?string $title = 'FR.APL.02';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Asesmen Mandiri';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        // $this->form->fill(
        //     $this->getRecord()->ortu->toArray(),
        // );
    }
}
