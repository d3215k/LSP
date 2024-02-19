<x-filament::section>
    <x-slot name="heading">
        Pendaftaran Asesmen Baru
    </x-slot>

    <form wire:submit="handleSubmit">

        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Daftar
        </x-filament::button>
    </form>

    <x-filament-actions::modals />

</x-filament::section>
