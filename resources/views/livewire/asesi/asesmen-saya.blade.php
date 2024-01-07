<x-filament::section>
    <x-slot name="heading">
        Asesmen Saya
    </x-slot>

    <div class="flex flex-col gap-4 md:flex-row">
        <div class="aspect-video">
            @if ($this->asesmen->skema->cover)
                <img class=" object-cover h-36" src="/storage/{{ $this->asesmen->skema->cover }}">
            @else
                <div class="flex items-center h-full px-4 justify-center text-lg font-semibold text-gray-200 bg-gray-400 rounded-md">
                    {{ config('app.name') }}
                </div>
            @endif
        </div>
        <div class="flex flex-col flex-1 gap-2">
            <div class="font-semibold">
                {{ $this->asesmen->skema->nama }}
            </div>

            <div class="text-sm">
                Status : <span class="font-medium text-primary-600 dark:text-primary-400">{{ $this->asesmen->status->getLabel() }}</span>
            </div>

            <a href="{{ $route }}" wire:navigate class="mt-4">
                <x-filament::button>
                    Lanjutkan
                </x-filament::button>
            </a>
        </div>
    </div>

</x-filament::section>
