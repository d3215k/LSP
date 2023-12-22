<x-filament::section>
    <x-slot name="heading">
        Bagian 1 : Dokumen Bukti Asesmen Mandiri
    </x-slot>

    <x-slot name="description">
        Upload Semua Dokumen Bukti-bukti Untuk Mendukung Asesmen Mandiri
    </x-slot>

    {{ $this->table }}

    <form>
        <x-filament::button wire:click="handleSubmit" type="button" class="mt-2">
            Submit
        </x-filament::button>
    </form>

    {{-- <x-filament-actions::modals /> --}}

</x-filament::section>
