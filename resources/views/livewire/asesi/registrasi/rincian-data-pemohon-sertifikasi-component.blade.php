<x-filament::section>
    <x-slot name="heading">
        Bagian 1 : Rincian Data Pemohon Sertifikasi
    </x-slot>

    <x-slot name="description">
        Pada bagian ini cantumkan data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini.
    </x-slot>

    <form wire:submit="save">

        {{ $this->form }}

        <x-filament::button type="submit" class="mt-2">
            Simpan
        </x-filament::button>
    </form>

    <x-filament-actions::modals />

</x-filament::section>
