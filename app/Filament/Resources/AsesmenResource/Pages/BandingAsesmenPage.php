<?php

namespace App\Filament\Resources\AsesmenResource\Pages;

use App\Filament\Resources\AsesmenResource;
use App\Models\Asesmen\Banding;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class BandingAsesmenPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithRecord;
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static string $resource = AsesmenResource::class;

    protected static string $view = 'filament.resources.asesmen-resource.pages.banding-asesmen-page';

    protected static ?string $title = 'FR.AK.04';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public ?array $data = [];

    public $isShow = false;

    public function getHeading(): string
    {
        return $this->getRecord()->asesi->nama;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Banding Asesmen';
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->isShow = isset($this->getRecord()->banding);

        $this->form->fill($this->record->banding?->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('telah_dijelaskan')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Proses Banding telah dijelaskan kepada Anda?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Radio::make('telah_diskusi')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Anda telah mendiskusikan Banding dengan Asesor?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Radio::make('melibatkan')
                    ->boolean('Ya', 'Tidak')
                    ->label('Apakah Anda mau melibatkan “orang lain” membantu Anda dalam Proses Banding?')
                    // ->inline()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Textarea::make('alasan')
                    ->label('Banding ini diajukan atas alasan sebagai berikut :')
                    ->required()
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    public function handleSave()
    {
        try {
            DB::beginTransaction();

            $data = $this->form->getState();
            $data['tanggal'] = today();

            Banding::updateOrCreate(['asesmen_id' => $this->record->id], $data);

            DB::commit();
            Notification::make()->title('Data Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            report($th->getMessage());
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }
}
