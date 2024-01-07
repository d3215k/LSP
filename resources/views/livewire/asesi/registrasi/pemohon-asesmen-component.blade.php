<div>
    <x-filament::fieldset>
        <x-slot name="label">
            Pemohon/Kandidat
        </x-slot>

        @if ($asesmen->rincianDataPemohon)
            {{ $this->asesiInfolist }}
        @endif

        <div class="mt-6">
            @if ($asesmen->ttd_asesi)
                <div class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Tanda tangan asesi
                </div>
                <img width="250px" alt="{{ 'ttd of '.$asesmen->rincianDataPemohon?->nama }}" src="{{ asset('storage/'.$asesmen?->ttd_asesi) }}" />
            @else
                {{ $this->form }}
            @endif
        </div>

    </x-filament::fieldset>

    @if (!$asesmen->ttd_asesi)
    <x-filament::button class="mt-4" wire:click="handleSubmit" wire:confirm="Anda yakin untuk submit Pendaftaran APL 01?">
        Simpan
    </x-filament::button>
    @endif
</div>
