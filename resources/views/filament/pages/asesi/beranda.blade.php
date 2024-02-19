<x-filament-panels::page>

    <p class="font-semibold">Hai, <span class="uppercase">{{ auth()->user()->name }}</span></p>

    @if ($showAsesmenSaya)
        <livewire:asesi.asesmen-saya />
    @endif

    <livewire:asesi.pendaftaran-asesmen-component />

</x-filament-panels::page>
