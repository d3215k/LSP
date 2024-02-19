<x-filament::section>
    <x-slot name="heading">
        Asesmen Saya
    </x-slot>

    <div class="space-y-6">
        @foreach ($this->asesmen as $asesmen)
            <x-asesmen-card :asesmen="$asesmen" wire:key="{{ $asesmen->id }}" />
        @endforeach
    </div>

</x-filament::section>
