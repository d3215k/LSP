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
    <x-filament::section>
        <x-slot name="heading">
            Bagian 1 : Rincian Data Pemohon Sertifikasi
        </x-slot>

        <x-slot name="description">
            Pada bagian ini cantumkan data pribadi, data pendidikan format serta data pekerjaan anda pada saat ini.
        </x-slot>


    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            Data Sertifikasi
        </x-slot>

        <h1>Isi FR.APL.01</h1>
    </x-filament::section>
    @endif

    @if ($activeTab === 'tab2')
    <x-filament::section>
        <x-slot name="heading">
            FR.APL.02
        </x-slot>

        <h1>Isi FR.APL.01</h1>
    </x-filament::section>
    @endif

</x-filament-panels::page>
