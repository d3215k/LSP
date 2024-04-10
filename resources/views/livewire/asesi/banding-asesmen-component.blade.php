<x-filament::section>
    <form wire:submit="handleSave">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-6">
            Simpan
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</x-filament::section>
