<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\Asesmen\Banding;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BandingAsesmenComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Asesmen $asesmen;

    public ?array $data = [];

    public function mount()
    {
        abort_unless(
            auth()->user()->isAsesi && $this->asesmen->asesi_id === auth()->user()->asesi_id
        , 403);

        $this->form->fill($this->asesmen->banding?->toArray());

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

            Banding::updateOrCreate(['asesmen_id' => $this->asesmen->id], $data);

            DB::commit();
            Notification::make()->title('Data Tersimpan')->success()->send();

        } catch (\Throwable $th) {
            report($th->getMessage());
            Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.asesi.banding-asesmen-component');
    }
}
