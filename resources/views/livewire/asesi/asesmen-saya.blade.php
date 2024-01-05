<x-filament::section>
    <x-slot name="heading">
        Asesmen Saya
    </x-slot>

    <div class="flex flex-col md:flex-row gap-4">
        <div class="aspect-video h-36">
            @if ($this->asesmen->skema->cover)
                <img src="/storage/{{ $this->asesmen->skema->cover }}">
            @else
                <div class="bg-gray-400 h-full font-semibold text-lg rounded-md flex items-center justify-center text-gray-200">
                    {{ config('app.name') }}
                </div>
            @endif
        </div>
        <div class="flex flex-col flex-1 gap-2">
            <div class="font-semibold">
                {{ $this->asesmen->skema->nama }}
            </div>

            <div class="text-sm font-medium text-primary-600 dark:text-primary-400">
                {{ $this->asesmen->status->getLabel() }}
            </div>

            <a href="{{ $route }}" wire:navigate>
                <x-filament::button>
                    Lanjutkan
                </x-filament::button>
            </a>
        </div>
    </div>

</x-filament::section>
