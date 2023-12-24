<x-filament::section>
    <x-slot name="heading">
        Bagian 3 : Bukti Kelengkapan Pemohon
    </x-slot>

    <x-slot name="description">
        Bukti Persyaratan Dasar Pemohon
    </x-slot>

    {{ $this->table }}

    <form>

        <p class="py-2">Tanda tangan</p>

        <x-signature-pad wire:model="signature"/>

        <x-filament::button wire:click="handleSubmit" type="submit" class="mt-2">
            Submit
        </x-filament::button>
    </form>

    {{-- <x-filament-actions::modals /> --}}

</x-filament::section>
