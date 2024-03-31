<?php

namespace App\Livewire\Asesi;

use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisEsai;
use App\Models\Asesmen\PertanyaanTertulisEsai;
use App\Models\Asesmen\TertulisEsai;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Livewire\Attributes\Computed;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CbtEsaiComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public Asesmen $asesmen;

    public ?array $data = [];

    public $selectedPertanyaan = 0;

    #[Computed(persist: true)]
    public function tertulisEsai() {
        return TertulisEsai::firstOrCreate(
            [
                'asesmen_id' => $this->asesmen->id,
            ],
            [
                'tanggal_asesmen' => today(),
            ]
        );
    }

    #[Computed(persist: true)]
    public function unitIds()
    {
        return $this->asesmen->skema->unit->pluck('id');
    }

    #[Computed(persist: true)]
    public function pertanyaanEsai() {
        $hasil = JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->tertulisEsai?->id)
            ->pluck('jawaban', 'pertanyaan_tertulis_esai_id')
            ->toArray();

        return PertanyaanTertulisEsai::whereIn('unit_id', $this->unitIds)
            ->get()->map(function ($item) use ($hasil) {
                $item->dijawab = array_key_exists($item->id, $hasil);
                return $item;
            });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('pertanyaan_tertulis_esai_id'),
                RichEditor::make('jawaban')
            ])
            ->statePath('data');
    }

    public function prev()
    {
        $this->selectedPertanyaan--;
        $this->save();
        unset($this->jawaban);

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

        $this->save();
        unset($this->jawaban);

    }

    public function finish()
    {
        $this->save();
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

        unset($this->pertanyaanEsai);

    }

    #[Computed(persist: true)]
    public function jawaban()
    {
        $pertanyaan = $this->pertanyaanEsai[$this->selectedPertanyaan];

        return JawabanTertulisEsai::query()
            ->where('asesmen_tertulis_esai_id', $this->tertulisEsai?->id)
            ->where('pertanyaan_tertulis_esai_id', $pertanyaan->id)
            ->select('jawaban')
            ->first();
    }

    public function render()
    {
        $pertanyaan = $this->pertanyaanEsai[$this->selectedPertanyaan];

        $this->form->fill([
            'jawaban' => $this->jawaban?->jawaban,
            'pertanyaan_tertulis_esai_id' => $pertanyaan->id
        ]);

        return view('livewire.asesi.cbt-esai-component', [
            'pertanyaan' => $pertanyaan,
        ]);
    }
}
