<div>
    <x-filament::fieldset>
        <x-slot name="label">
            Pemohon/Kandidat
        </x-slot>

        @if ($asesmen->rincian)
            {{ $this->asesiInfolist }}
        @endif

        <form class="mt-6">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tanda tangan</p>

            <div class="mt-6">
                @if ($asesmen->rincian->ttd)
                    <img width="300px" alt="{{ 'ttd of '.$asesmen->rincian->nama }}" src="{{ asset('storage/'.$asesmen->rincian->ttd) }}" />
                @else
                <x-signature-pad wire:model="signature"/>
                @endif
            </div>
        </form>

    </x-filament::fieldset>

    <x-filament::button class="mt-4" wire:click="handleSubmit" wire:confirm="Apakah anda yakin semua data sudah benar?">
        Simpan
    </x-filament::button>
</div>
