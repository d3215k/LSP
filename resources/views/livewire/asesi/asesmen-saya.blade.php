<x-filament::section>
    <x-slot name="heading">
        Asesmen Saya
    </x-slot>

    <div class="md:flex md:gap-4">
        <div class=" aspect-video max-h-32">
            <img src="https://static-asset-cdn.prakerja.go.id/Microsoft%20Data%20Azure%20-%20Thumbnail%20MCT.webp">
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
                    {{ $label }}
                </x-filament::button>
            </a>
        </div>
    </div>

</x-filament::section>
