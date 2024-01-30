<?php

namespace App\Livewire\Asesi\PermohonanSertifikasiKompetensi;

use App\Enums\TujuanAsesmen;
use App\Models\Asesmen;
use App\Models\Skema\Unit;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class DataSertifikasiComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public ?array $data = [];

    public Asesmen $asesmen;

    public function mount(): void
    {
        $this->form->fill($this->asesmen->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Skema Sertifikasi (Okupasi)')
                    ->schema([
                        Placeholder::make('judul')
                            ->content($this->asesmen->skema->nama)
                            ->inlineLabel(),
                        Placeholder::make('nomor')
                            ->content($this->asesmen->skema->kode)
                            ->inlineLabel(),
                    ])->columns(1),
                Select::make('tujuan')
                    ->options(TujuanAsesmen::class)
                    ->inlineLabel()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Unit::query()->where('skema_id', $this->asesmen->skema->id))
            ->columns([
                TextColumn::make('kode'),
                TextColumn::make('judul')
                    ->wrap(),
            ])
            ->paginated(false);
    }

    public function handleSubmit(): void
    {
        $this->asesmen->update($this->form->getState());

        Notification::make()
            ->title('Berhasil disimpan!')
            ->body('Bagian 2 : Data Sertifikasi')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.asesi.registrasi.data-sertifikasi-component');
    }
}
