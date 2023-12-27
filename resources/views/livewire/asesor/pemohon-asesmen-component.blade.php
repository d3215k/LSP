<div>
    <x-filament::section>
        <x-slot name="heading">
            Pemohon/Kandidat
        </x-slot>

        @if ($mandiri->asesmen->rincianDataPemohon)
            {{ $this->asesiInfolist }}
        @endif

        <form class="mt-6">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tanda tangan</p>

            <div class="mt-6">
                <img width="300px" alt="{{ 'ttd of '.$mandiri->asesmen->rincianDataPemohon->nama }}" src="{{ asset('storage/'.$mandiri->asesmen->ttd_asesi) }}" />
            </div>
        </form>

    </x-filament::section>
</div>
