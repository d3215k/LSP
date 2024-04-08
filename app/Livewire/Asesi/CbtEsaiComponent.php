<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenTertulisStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\PertanyaanTertulisEsai;
use App\Models\Asesmen\TertulisEsai;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Livewire\Attributes\Computed;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class CbtEsaiComponent extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $asesmenId;

    public ?array $data = [];

    #[Url()]
    public $selectedPertanyaan = 0;

    public function mount()
    {
        $this->fetch();
    }

    #[Computed(persist: true)]
    public function asesmen() {
        $asesmen = Asesmen::select('id', 'skema_id')
            ->find($this->asesmenId);

        $asesmen->load(
            'skema:id,durasi_tertulis_esai',
            'skema.unit:id,skema_id'
        );

        return $asesmen;
    }

    #[Computed(persist: true)]
    public function tertulisEsai() {
        return TertulisEsai::where('asesmen_id', $this->asesmen->id)
            ->select('id','created_at')
            ->first();
    }

    #[Computed(persist: true)]
    public function unitIds()
    {
        return $this->asesmen->skema->unit->pluck('id');
    }

    #[Computed(persist: true)]
    public function pertanyaanEsai() {
        return PertanyaanTertulisEsai::whereIn('unit_id', $this->unitIds)
            ->select('id','pertanyaan')
            ->get();
    }

    #[Computed(persist: true)]
    public function jawabanTertulisEsai()
    {
        return JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->tertulisEsai?->id)
            ->pluck('jawaban', 'pertanyaan_tertulis_esai_id')
            ->toArray();
    }

    #[Computed(persist: true)]
    public function pertanyaan()
    {
        return $this->pertanyaanEsai[$this->selectedPertanyaan] ?? [];
    }

    #[Computed(persist: true)]
    public function jawaban()
    {
        return JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->tertulisEsai?->id)
            ->where('pertanyaan_tertulis_esai_id', $this->pertanyaan->id)
            ->select('jawaban')
            ->first();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('pertanyaan_tertulis_esai_id'),
                RichEditor::make('jawaban')
                    ->autofocus(false)
            ])
            ->statePath('data');
    }

    public function fetch()
    {
        $this->save();

        unset($this->pertanyaan);
        unset($this->jawaban);

        $this->form->fill([
            'jawaban' => $this->jawaban?->jawaban,
            'pertanyaan_tertulis_esai_id' => $this->pertanyaan->id
        ]);
    }

    public function prev()
    {
        $this->selectedPertanyaan--;
        $this->fetch();

    }

    public function next($index = null)
    {
        if($this->selectedPertanyaan === count($this->pertanyaanEsai)) {
            return $this->finish();
        }

        if (isset($index) || $index === 0) {
            $this->selectedPertanyaan = (int) $index;
        } else {
            $this->selectedPertanyaan++;
        }

        $this->fetch();

    }

    #[On('timeup')]
    public function finish()
    {
        $this->save();
        $this->tertulisEsai->update([
            'status' => AsesmenTertulisStatus::SELESAI
        ]);
        return $this->redirectRoute('asesi.asesmen.tertulis.esai', ['asesmen' => $this->asesmen->id], navigate: true);
    }

    public function finishAction(): Action
    {
        return Action::make('finish')
            ->label('Selesai')
            ->action(fn () => $this->finish())
            ->requiresConfirmation()
            ->icon('heroicon-m-check')
            ->modalHeading('Selesaikan Asesmen')
            ->modalDescription('Yakin ingin menyelesaikan dan mengakhiri Asesmen Tertulis?')
            ->modalSubmitActionLabel('Selesaikan')
            ;
    }

    public function save()
    {
        $data = $this->form->getState();

        if (empty($data['jawaban']) || $data['jawaban'] === $this->jawaban?->jawaban) {
            return;
        }

        JawabanTertulisEsai::updateOrCreate(
            [
                'asesmen_tertulis_esai_id' => $this->tertulisEsai->id,
                'pertanyaan_tertulis_esai_id' => $data['pertanyaan_tertulis_esai_id'],
            ],
            [
                'jawaban' => $data['jawaban'],
            ],
        );

        unset($this->jawabanTertulisEsai);
    }

    public function render()
    {
        return view('livewire.asesi.cbt-esai-component');
    }
}
