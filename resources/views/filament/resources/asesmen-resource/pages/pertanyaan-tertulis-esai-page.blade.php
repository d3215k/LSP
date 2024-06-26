<x-filament-panels::page>
    @if ($isShow)
        <div class="flex flex-col">
            <div class="space-y-6 flex-grow">
                @foreach ($record->skema->unit as $unit)
                    @if ($unit->pertanyaanTertulisEsai->count() > 0)
                    <div class="space-y-4 fi-ta" wire:key="{{ $unit->id }}">
                        <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow-sm fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                            <div class="overflow-x-auto divide-y divide-gray-200 fi-ta-content dark:divide-white/10 dark:border-t-white/10">
                                <table class="w-full divide-y divide-gray-200 table-auto fi-ta-table text-start dark:divide-white/5">
                                    <thead class="bg-gray-100 divide-y divide-gray-200 dark:bg-white/5">
                                        <tr class="divide-x divide-gray-200">
                                            <th rowspan="2" class="w-48 px-3 py-2">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        Unit Kompetensi {{ $loop->iteration }}
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="w-24 px-3 py-2">
                                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        Kode Unit
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="w-4 px-3 py-2">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        :
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="px-3 py-2">
                                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                                    <span class="flex flex-col text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        {{ $unit->kode }}
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                        <tr class="divide-x divide-gray-200">
                                            <th class="w-24 px-3 py-2 border-l border-gray-200">
                                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        Judul Unit
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="w-4 px-3 py-2">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        :
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="px-3 py-2">
                                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                                    <span class="flex flex-col text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        {{ $unit->judul }}
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow-sm fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                            <div class="overflow-x-auto divide-y divide-gray-200 fi-ta-content dark:divide-white/10 dark:border-t-white/10">
                                <table class="w-full divide-y divide-gray-200 table-auto fi-ta-table text-start dark:divide-white/5">
                                    <thead class="bg-gray-100 divide-y divide-gray-200 dark:bg-white/5">
                                        <tr class="divide-x divide-gray-200">
                                            <th rowspan="2" class="w-4 px-3 py-2">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        No
                                                    </span>
                                                </span>
                                            </th>
                                            <th rowspan="2" class="px-3 py-2 min-w-36">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        Pertanyaan
                                                    </span>
                                                </span>
                                            </th>
                                            <th colspan="2" class="px-3 py-2">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-nowrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        Rekomendasi
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                        <tr class="divide-x divide-gray-200">
                                            <th class="px-3 py-2 border border-gray-200">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        K
                                                    </span>
                                                </span>
                                            </th>
                                            <th class="px-3 py-2 border border-gray-200">
                                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                        BK
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                                        @foreach ($unit->pertanyaanTertulisEsai as $pertanyaan)
                                            <tr wire:key="pertanyaan-tertulis-esai-{{ $pertanyaan->id }}" class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                                <td class="p-0 fi-ta-cell">
                                                    <div class="text-center fi-ta-col-wrp">
                                                        {{ $loop->iteration; }}
                                                    </div>
                                                </td>
                                                <td class="p-4 border-l border-gray-200 text-wrap fi-ta-cell">
                                                    <div class="text-wrap">
                                                        <div class="fi-ta-col-wrp max-w-screen-lg p-4 prose dark:prose-invert bg-white dark:bg-gray-900">
                                                            {!! $pertanyaan->pertanyaan !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="w-12 p-0 fi-ta-cell">
                                                    <div class="fi-ta-col-wrp">
                                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                            <div class="fi-ta-text-item">
                                                                <label>
                                                                    <input type="radio" class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                                        id="data.kompeten.{{ $pertanyaan->id }}.K"
                                                                        name="data.kompeten.{{ $pertanyaan->id }}"
                                                                        value="K"
                                                                        @disabled(! auth()->user()->isAsesor)
                                                                        wire:loading.attr="disabled"
                                                                        wire:model="data.kompeten.{{ $pertanyaan->id }}"
                                                                    >

                                                                    <div class="sr-only">
                                                                        <span>
                                                                            K
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="w-12 p-0 fi-ta-cell">
                                                    <div class="fi-ta-col-wrp">
                                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                            <div class="fi-ta-text-item">
                                                                <label>
                                                                    <input type="radio" class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                                        id="data.kompeten.{{ $pertanyaan->id }}.BK"
                                                                        name="data.kompeten.{{ $pertanyaan->id }}"
                                                                        value="BK"
                                                                        @disabled(! auth()->user()->isAsesor)
                                                                        wire:loading.attr="disabled"
                                                                        wire:model="data.kompeten.{{ $pertanyaan->id }}"
                                                                    >

                                                                    <div class="sr-only">
                                                                        <span>
                                                                            BK
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            @if (isset($data['jawaban'][$pertanyaan->id]))
                                                <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                                    <td x-data="{ open: true }" colspan="4" class="fi-ta-cell">
                                                        <div class="fi-ta-col-wrp">
                                                            <button class="bg-success-100 dark:bg-success-800 py-2 px-4 w-full text-left font-medium text-sm" x-on:click="open = ! open">
                                                                Jawaban Asesi No. {{ $loop->iteration }}
                                                            </button>
                                                            <div x-show="open" class="max-w-screen-lg p-4 prose dark:prose-invert bg-white dark:bg-gray-900">
                                                                {!! $data['jawaban'][$pertanyaan->id] !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @isset($pertanyaan->jawaban)
                                                <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                                    <td x-data="{ open: true }" colspan="4" class="fi-ta-cell">
                                                        <div class="fi-ta-col-wrp">
                                                            <button class="bg-primary-100 dark:bg-primary-800 py-2 px-4 w-full text-left font-medium text-sm" x-on:click="open = ! open">
                                                                Kunci Jawaban No. {{ $loop->iteration }}
                                                            </button>
                                                            <div x-show="open" class="max-w-screen-lg p-4 prose dark:prose-invert bg-white dark:bg-gray-900">
                                                                {!! $pertanyaan->jawaban !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endisset
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            @if (auth()->user()->isAsesor)
            <div class="sticky bottom-0">
                <div class="flex justify-end shadow-sm px-6 bg-gray-100 border border-gray-200">
                    <div class="py-4 px-8">
                        <x-filament::button wire:click="handleSave">
                            Simpan
                        </x-filament::button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @else
        <div class="text-gray-400 text-md text-center">
            Asesi belum mengisi atau Pertanyaan Tertulis Esai tidak diaktifkan.
        </div>
    @endif

</x-filament-panels::page>
