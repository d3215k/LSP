<?php

namespace App\Livewire\Asesi;

use App\Enums\AsesmenTertulisStatus;
use App\Models\Asesmen;
use App\Models\Asesmen\JawabanTertulisPilihanGanda;
use App\Models\Asesmen\PertanyaanTertulisPilihanGanda;
use App\Models\Asesmen\PilihanJawaban;
use App\Models\Asesmen\TertulisPilihanGanda;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Livewire\Attributes\Computed;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class CbtPilihanGandaComponent extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $asesmenId;

    public ?array $data = [];

    public $pilihanJawaban;

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
            'skema:id,durasi_tertulis_pilihan_ganda',
            'skema.unit:id,skema_id'
        );

        return $asesmen;
    }

    #[Computed(persist: true)]
    public function tertulisPilihanGanda() {
        return TertulisPilihanGanda::where('asesmen_id', $this->asesmen->id)->first();
    }

    #[Computed(persist: true)]
    public function unitIds()
    {
        return $this->asesmen->skema->unit->pluck('id');
    }

    #[Computed(persist: true)]
    public function pertanyaanPilihanGanda() {
        return PertanyaanTertulisPilihanGanda::whereIn('unit_id', $this->unitIds)
            ->with('pilihanJawaban:pertanyaan_tertulis_pilihan_ganda_id,id,jawaban')
            ->get();
    }

    #[Computed(persist: true)]
    public function jawabanTertulisPilihanGanda()
    {
        return JawabanTertulisPilihanGanda::query()
            ->where('asesmen_tertulis_pilihan_ganda_id', $this->tertulisPilihanGanda?->id)
            ->pluck('pilihan_jawaban_id', 'pertanyaan_tertulis_pilihan_ganda_id')
            ->toArray();
    }

    #[Computed(persist: true)]
    public function jawaban()
    {
        return JawabanTertulisPilihanGanda::query()
            ->where('asesmen_tertulis_pilihan_ganda_id', $this->tertulisPilihanGanda?->id)
            ->where('pertanyaan_tertulis_pilihan_ganda_id', $this->pertanyaan->id)
            ->select('pilihan_jawaban_id')
            ->first();
    }

    #[Computed(persist: true)]
    public function pertanyaan()
    {
        return $this->pertanyaanPilihanGanda[$this->selectedPertanyaan];
    }

    public function fetch()
    {
        $this->save();

        unset($this->pertanyaan);
        unset($this->jawaban);

        $this->data['pertanyaan_tertulis_pilihan_ganda_id'] = $this->pertanyaan->id;
        $this->data['pilihan_jawaban_id'] = $this->jawaban?->pilihan_jawaban_id;
    }

    public function prev()
    {
        $this->selectedPertanyaan--;

        $this->fetch();
    }

    public function next($index = null)
    {
        if ($this->selectedPertanyaan === count($this->pertanyaanPilihanGanda)) {
            return $this->finish();
        }

        if (isset($index) || $index === 0) {
            $this->selectedPertanyaan = (int) $index;
        } else {
            $this->selectedPertanyaan++;
        }

        $this->fetch();
    }

    public function save()
    {
        if (empty($this->data['pilihan_jawaban_id']) || $this->data['pilihan_jawaban_id'] === $this->jawaban?->pilihan_jawaban_id) {
            return;
        }

        $pilihanJawaban = PilihanJawaban::query()
            ->where('id', $this->data['pilihan_jawaban_id'])
            ->select('kompeten')
            ->first();

        JawabanTertulisPilihanGanda::updateOrCreate(
            [
                'asesmen_tertulis_pilihan_ganda_id' => $this->tertulisPilihanGanda->id,
                'pertanyaan_tertulis_pilihan_ganda_id' => $this->data['pertanyaan_tertulis_pilihan_ganda_id'],
            ],
            [
                'pilihan_jawaban_id' => $this->data['pilihan_jawaban_id'],
                'kompeten' => $pilihanJawaban->kompeten,
            ],
        );

        unset($this->jawabanTertulisPilihanGanda);
    }

    #[On('timeup')]
    public function finish()
    {
        $this->save();
        $this->tertulisPilihanGanda->update([
            'status' => AsesmenTertulisStatus::SELESAI
        ]);
        return $this->redirectRoute('asesi.asesmen.tertulis.pilihan.ganda', ['asesmen' => $this->asesmen->id], navigate: true);
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
            ->modalSubmitActionLabel('Selesaikan');
    }

    public function render()
    {
        return view('livewire.asesi.cbt-pilihan-ganda-component');
    }
}
