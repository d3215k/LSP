<div>
    <x-filament::section>
        <x-slot name="heading">
            Penilaian Asesmen Mandiri
        </x-slot>

        <x-filament::fieldset>
            <x-slot name="label">
                Asesor
            </x-slot>

            @if ($mandiri->asesmen->asesor)
                {{ $this->asesorInfolist }}
            @endif

            <form class="mt-6">
                <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tanda tangan</p>

                <div class="mt-6">
                    @if ($mandiri->asesmen->ttd_asesor)
                        <img width="300px" alt="{{ 'ttd of '.$mandiri->asesmen->asesor->nama }}" src="{{ asset('storage/'.$mandiri->asesmen->ttd_asesor) }}" />
                    @else
                        <x-signature-pad wire:model="signature"/>
                    @endif
                </div>

                <div class="mt-6">
                    {{ $this->form }}
                </div>
            </form>

        </x-filament::fieldset>

    </x-filament::section>

    <x-filament::button class="mt-4" wire:click="handleSubmit">
        Simpan
    </x-filament::button>
</div>
