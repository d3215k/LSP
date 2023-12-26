<div>
    <x-filament::fieldset>
        <x-slot name="label">
            Pemohon/Kandidat
        </x-slot>

        @if ($asesmen->rincianDataPemohon)
            {{ $this->asesiInfolist }}
        @endif

        <form class="mt-6">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tanda tangan</p>

            <div class="mt-6">
                @if ($asesmen->ttd_asesi)
                    <img width="300px" alt="{{ 'ttd of '.$asesmen->rincianDataPemohon->nama }}" src="{{ asset('storage/'.$asesmen->ttd_asesi) }}" />
                @else
                    <x-signature-pad wire:model="signature"/>
                @endif
            </div>
        </form>

    </x-filament::fieldset>

    <x-filament::button class="mt-4" wire:click="handleSubmit" wire:confirm="Anda yakin untuk submit Pendaftaran APL 01?">
        Simpan
    </x-filament::button>
</div>
