
<div  class="flex flex-col gap-4 md:flex-row">
    <div class="aspect-video">
        @if ($asesmen->skema->cover)
            <img class="object-cover h-36" src="/storage/{{ $asesmen->skema->cover }}">
        @else
            <div class="flex items-center h-full px-4 justify-center text-lg font-semibold text-gray-200 bg-gray-400 rounded-md">
                {{ config('app.name') }}
            </div>
        @endif
    </div>
    <div class="flex flex-col flex-1 gap-2">
        <div class="font-semibold">
            {{ $asesmen->skema->nama }}
        </div>

        <div class="text-sm">
            Status : <span class="font-medium text-primary-600 dark:text-primary-400">{{ $asesmen->status === \App\Enums\AsesmenStatus::REGISTRASI ? 'Submit / Menunggu Verifikasi Admin' : $asesmen->status->getLabel() }}</span>
        </div>

        @php
            $route = match ($asesmen->status->value) {
                1 => route('filament.app.pages.asesi.{record}.permohonan-sertifikasi-kompetensi', $asesmen->id),
                2 => route('filament.app.pages.asesi.{record}.asesmen-mandiri', $asesmen->id),
                3,4,5,6 => route('filament.app.pages.asesi.{record}.asesmen-tertulis-esai', $asesmen->id),
                11 => route('filament.app.pages.asesi.{record}.umpan-balik', $asesmen->id),
                12,13 => route('filament.app.pages.asesi.{record}.banding-asesmen', $asesmen->id),
            };

            $label = match ($asesmen->status->value) {
                1 => 'FR.APL.01 PERMOHONAN SERTIFIKASI KOMPETENSI',
                2 => 'FR.APL.02 ASESMEN MANDIRI',
                3,4,5,6 => 'FR.IA.06 PERTANYAAN TERTULIS', // TODO : PG atau ESAI
                11 => 'FR.AK.03 UMPAN BALIK DAN CATATAN ASESMEN',
                12,13 => 'FR.AK.04 BANDING ASESMEN',
            };
        @endphp

        <a href="{{ $route }}" wire:navigate class="mt-4">
            <x-filament::button>
                {{ $label }}
            </x-filament::button>
        </a>
    </div>
</div>
