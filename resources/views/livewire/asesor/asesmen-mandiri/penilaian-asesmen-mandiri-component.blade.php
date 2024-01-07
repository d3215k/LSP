<div>
    <x-filament::section>
        <x-slot name="heading">
            Asesor
        </x-slot>

        @if ($mandiri->asesmen->asesor)
                {{ $this->asesorInfolist }}
            @endif

        <form class="mt-6">
            <div>
                {{ $this->rekomendasiForm }}
            </div>

            @if ($mandiri->asesmen->ttd_asesor)
                <div class="text-sm mt-8 font-medium leading-6 text-gray-950 dark:text-white">
                    Tanda tangan
                </div>
                <img width="250px" alt="{{ 'ttd of '.$mandiri->asesmen->asesor->nama }}" src="{{ asset('storage/'.$mandiri->asesmen->ttd_asesor) }}" />
            @else
                <div class="mt-6">
                    {{ $this->ttdAsesorForm }}
                </div>
            @endif
        </form>


    </x-filament::section>

    <x-filament::button class="mt-4" wire:click="handleSubmit">
        Simpan
    </x-filament::button>
</div>
