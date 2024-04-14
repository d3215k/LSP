<x-filament-panels::page>
    @if ($isShow)
        <form wire:submit="handleSave">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-6">
                Simpan
            </x-filament::button>
        </form>
    @else
        <div class="text-gray-400 text-md text-center">
            Asesi belum mengisi Banding Asesmen.
        </div>
    @endif
</x-filament-panels::page>
