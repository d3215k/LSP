<x-filament-panels::page>

    <p class="font-semibold">Hai, <span class="uppercase">{{ auth()->user()->name }}</span></p>

    @if ($showPendaftaranAsesmenBaru)
        <livewire:asesi.pendaftaran-asesmen-component />
    @endif

    @if ($showAsesmenSaya)
        <livewire:asesi.asesmen-saya />
    @endif

</x-filament-panels::page>
