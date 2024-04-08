<?php

namespace App\Livewire\Asesi;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use App\Models\Asesmen;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Computed;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Livewire\Component;

class CbtOnboardingTertulisEsaiComponent extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithActions;
    use InteractsWithInfolists;
    use InteractsWithForms;

    public $asesmenId;

    public ?array $data = [];

    #[Computed(persist: true)]
    public function asesmen() {
        $asesmen = Asesmen::select('id', 'asesi_id', 'skema_id')
            ->find($this->asesmenId);

        $asesmen->load(
            'skema:id,nama,durasi_tertulis_esai',
            'tertulisEsai:status,asesmen_id',
            'asesi:id,nama'
        );

        return $asesmen;
    }

    public function asesmenInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->asesmen)
            ->schema([
                TextEntry::make('asesi.nama')
                    ->label('Nama Asesi'),
                TextEntry::make('skema.nama'),
                TextEntry::make('skema.durasi_tertulis_esai')
                    ->label('Waktu Pengerjaan')
                    ->suffix(' menit'),
                TextEntry::make('tertulisEsai.status')
                    ->label('Status')
                    ->badge()
                    ->hidden(fn (Asesmen $asesmen) => ! $asesmen->tertulisEsai)
            ]);
    }

    public function startAction(): Action
    {
        return Action::make('start')
            ->label('Mulai Asesmen Tertulis')
            ->action(function () {
                $this->asesmen->tertulisEsai()->create([
                    'tanggal_asesmen' => today()
                ]);

                return $this->redirectRoute('asesi.asesmen.tertulis.esai', ['asesmen' => $this->asesmenId]);
            })
            ->requiresConfirmation()
            ->modalDescription('Waktu dihitung setelah dimulai dan tidak dapat dijeda.')
            ->modalSubmitActionLabel('Mulai Sekarang');
    }

    public function render()
    {
        return view('livewire.asesi.cbt-onboarding-tertulis-esai-component');
    }
}
