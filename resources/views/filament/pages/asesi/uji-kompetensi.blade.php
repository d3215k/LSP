<x-filament-panels::page>
    <x-filament::tabs label="Content tabs" >
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            wire:click="$set('activeTab', 'tab1')"
        >
            FR.APL.01
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab2'"
            wire:click="$set('activeTab', 'tab2')"
        >
            FR.APL.02
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'tab3'"
            wire:click="$set('activeTab', 'tab3')"
        >
            FR.AK.01
        </x-filament::tabs.item>
    </x-filament::tabs>

    @if ($activeTab === 'tab1')

        @livewire('asesi.rincian-data-pemohon-sertifikasi')

        @livewire('asesi.data-sertifikasi')

        @livewire('asesi.bukti-kelengkapan-pemohon')

    @endif

    @if ($activeTab === 'tab2')

        {{-- @livewire('asesi.dokumen-bukti-asesmen-mandiri') --}}

        @livewire('asesi.asesmen-mandiri-component')

    @endif

</x-filament-panels::page>
