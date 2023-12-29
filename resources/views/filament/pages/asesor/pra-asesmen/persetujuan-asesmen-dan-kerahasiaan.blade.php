<x-filament-panels::page>

    {{ $this->persetujuanInfolist }}

    <div class="mt-4">
        <form wire:submit="handleSubmit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-4">
                Submit
            </x-filament::button>
        </form>

        <x-filament-actions::modals />
    </div>

</x-filament-panels::page>
