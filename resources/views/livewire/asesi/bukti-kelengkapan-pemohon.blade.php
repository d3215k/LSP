<x-filament::section>
    <x-slot name="heading">
        Bagian 3 : Bukti Kelengkapan Pemohon
    </x-slot>

    <x-slot name="description">
        Bukti Persyaratan Dasar Pemohon
    </x-slot>

    <form wire:submit="save">

        <ul>
            @forelse ($data['skema']?->persyaratan as $syarat)
            <li>{{ $syarat->id . ' / ' . $syarat->nama }}</li>
            @empty
            <li>Tidak ada</li>
            @endforelse
        </ul>

        <p class="py-2">Tanda tangan</p>

        <x-signature-pad wire:model="signature"/>

        <x-filament::button type="submit" class="mt-2">
            Submit
        </x-filament::button>
    </form>

    {{-- <x-filament-actions::modals /> --}}

</x-filament::section>
