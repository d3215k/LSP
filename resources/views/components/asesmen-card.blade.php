
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
            Status : <span class="font-medium text-primary-600 dark:text-primary-400">
                {{ $asesmen->status === \App\Enums\AsesmenStatus::REGISTRASI
                    ? 'Submit / Menunggu Verifikasi Admin'
                    : ( $asesmen->status === \App\Enums\AsesmenStatus::SELESAI_KOMPETEN ||
                        $asesmen->status === \App\Enums\AsesmenStatus::SELESAI_BELUM_KOMPETEN ||
                        $asesmen->status === \App\Enums\AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT
                        ? 'Selesai'
                        : $asesmen->status->getLabel()
                    )
                }}
            </span>
        </div>

        {{-- @php
            $route = match($asesmen->status->value) {
                1 => route('filament.app.pages.asesi.{record}.permohonan-sertifikasi-kompetensi', $asesmen->id),
                2 => route('filament.app.pages.asesi.{record}.asesmen-mandiri', $asesmen->id),
                3,4,5,6 => route('filament.app.pages.asesi.{record}.asesmen-tertulis-esai', $asesmen->id),
                11,12,13 => route('filament.app.pages.asesi.{record}.umpan-balik', $asesmen->id),
                // 12,13 => route('filament.app.pages.asesi.{record}.banding-asesmen', $asesmen->id),
            };

            $label = match($asesmen->status->value) {
                1 => 'FR.APL.01 PERMOHONAN SERTIFIKASI KOMPETENSI',
                2 => 'FR.APL.02 ASESMEN MANDIRI',
                3,4,5,6 => 'FR.IA.06 PERTANYAAN TERTULIS', // TODO : PG atau ESAI
                11,12,13 => 'FR.AK.03 UMPAN BALIK DAN CATATAN ASESMEN',
                // 12,13 => 'FR.AK.04 BANDING ASESMEN',
            };
        @endphp --}}

        <div class="flex flex-col md:flex-row gap-4 mt-4">

            @if ($asesmen->status->value >= 2)
                <a href="{{ route('filament.app.pages.asesi.{record}.permohonan-sertifikasi-kompetensi', $asesmen->id) }}" wire:navigate>
                    <x-filament::button>
                        FR.APL.01 PERMOHONAN SERTIFIKASI KOMPETENSI
                    </x-filament::button>
                </a>
            @endif

            @if ($asesmen->status->value === 2)
                <a href="{{ route('filament.app.pages.asesi.{record}.asesmen-mandiri', $asesmen->id) }}" wire:navigate>
                    <x-filament::button>
                        FR.APL.02 ASESMEN MANDIRI
                    </x-filament::button>
                </a>
            @endif

            @if (($asesmen->status->value >= 3 && $asesmen->status->value <= 6) && $asesmen->skema->tertulis_esai)
                {{-- <a href="{{ route('filament.app.pages.asesi.{record}.asesmen-tertulis-esai', $asesmen->id) }}" wire:navigate> --}}
                <a href="{{ route('asesi.asesmen.tertulis.esai', $asesmen->id) }}">
                    <x-filament::button>
                        FR.IA.06 PERTANYAAN TERTULIS
                    </x-filament::button>
                </a>
            @endif

            {{-- TODO: Tertulis PG --}}

            @if ($asesmen->status->value >= 11)
                <a href="{{ route('filament.app.pages.asesi.{record}.umpan-balik', $asesmen->id) }}" wire:navigate>
                    <x-filament::button>
                        FR.AK.03 UMPAN BALIK DAN CATATAN ASESMEN
                    </x-filament::button>
                </a>
            @endif

            @if ($asesmen->status->value >= 11 )
                <a href="{{ route('filament.app.pages.asesi.{record}.banding-asesmen', $asesmen->id) }}" wire:navigate>
                    <x-filament::button>
                        FR.AK.04 BANDING ASESMEN
                    </x-filament::button>
                </a>
            @endif
        </div>
    </div>
</div>
