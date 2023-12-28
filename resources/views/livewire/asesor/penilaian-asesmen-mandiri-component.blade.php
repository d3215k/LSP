<div>
    <x-filament::section>
        <x-slot name="heading">
            Asesor
        </x-slot>

        @if ($mandiri->asesmen->asesor)
                {{ $this->asesorInfolist }}
            @endif

        <form class="mt-6">
            <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]">
                <div class="fi-fo-field-wrp">
                    <div class="grid gap-y-2 sm:grid-cols-3 sm:gap-x-4 sm:items-center">
                        <div class="flex items-center justify-between gap-x-3">
                            <label class="inline-flex items-center fi-fo-field-wrp-label gap-x-3" for="data.catatan">
                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                    Tanda tangan
                                </span>
                            </label>
                        </div>
                        <div class="grid gap-y-2 sm:col-span-2">
                            <div class="flex overflow-hidden">
                                <div class="flex-1 min-w-0">
                                    @if ($mandiri->asesmen->ttd_asesor)
                                        <img width="300px" alt="{{ 'ttd of '.$mandiri->asesmen->asesor->nama }}" src="{{ asset('storage/'.$mandiri->asesmen->ttd_asesor) }}" />
                                    @else
                                        <x-signature-pad wire:model="signature"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                {{ $this->form }}
            </div>
        </form>

    </x-filament::section>

    <x-filament::button class="mt-4" wire:click="handleSubmit">
        Simpan
    </x-filament::button>
</div>
