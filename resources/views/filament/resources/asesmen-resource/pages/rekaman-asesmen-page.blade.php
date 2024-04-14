<x-filament-panels::page>
    <div class="fi-ta">
        <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow-sm fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
            <div class="overflow-x-auto divide-y divide-gray-200 fi-ta-content dark:divide-white/10 dark:border-t-white/10">
                <table class="w-full divide-y divide-gray-200 table-auto fi-ta-table text-start dark:divide-white/5">
                    <thead class="bg-gray-100 divide-y divide-gray-200 dark:bg-white/5">
                        <tr class="divide-x divide-gray-200">
                            <th class="w-4 px-3 py-2">
                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        No
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2 min-w-36">
                                <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Unit Kompetensi
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Observasi demonstrasi
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Portofolio
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Pernyataan Pihak Ketiga Pertanyaan Wawancara
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Pertanyaan lisan
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Pertanyaan tertulis
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Proyek kerja
                                    </span>
                                </span>
                            </th>
                            <th class="px-3 py-2">
                                <span class="flex items-center justify-start w-full group gap-x-1 whitespace-nowrap">
                                    <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                        Lainnya
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        @foreach ($record->skema->unit as $unit)
                            <tr wire:key="{{ $unit->id }}" class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                <td class="p-0 fi-ta-cell">
                                    <div class="text-center fi-ta-col-wrp">
                                        {{ $loop->iteration; }}
                                    </div>
                                </td>
                                <td class="p-4 border-l border-gray-200 text-wrap fi-ta-cell">
                                    <div class="text-wrap">
                                        <span>
                                            {{ $unit->judul }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.observasi_demonstrasi.{{ $unit->id }}"
                                                        name="state.observasi_demonstrasi.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.observasi_demonstrasi.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            Observasi demonstrasi
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.portofolio.{{ $unit->id }}"
                                                        name="state.portofolio.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.portofolio.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            Portofolio
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.pernyataan_pihak_ketiga_pertanyaan_wawancara.{{ $unit->id }}"
                                                        name="state.pernyataan_pihak_ketiga_pertanyaan_wawancara.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.pernyataan_pihak_ketiga_pertanyaan_wawancara.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            pernyataan_pihak_ketiga_pertanyaan_wawancara
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.pertanyaan_lisan.{{ $unit->id }}"
                                                        name="state.pertanyaan_lisan.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.pertanyaan_lisan.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            pertanyaan_lisan
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.pertanyaan_tertulis.{{ $unit->id }}"
                                                        name="state.pertanyaan_tertulis.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.pertanyaan_tertulis.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            pertanyaan_tertulis
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.proyek_kerja.{{ $unit->id }}"
                                                        name="state.proyek_kerja.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.proyek_kerja.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            proyek_kerja
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-0 fi-ta-cell">
                                    <div class="fi-ta-col-wrp">
                                        <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                            <div class="fi-ta-text-item">
                                                <label>
                                                    <input type="checkbox" class="transition duration-75 bg-white border-none rounded shadow-sm fi-checkbox-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                        id="state.lainnya.{{ $unit->id }}"
                                                        name="state.lainnya.{{ $unit->id }}"
                                                        wire:loading.attr="disabled"
                                                        wire:model="state.lainnya.{{ $unit->id }}"
                                                    >

                                                    <div class="sr-only">
                                                        <span>
                                                            lainnya
                                                        </span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $this->form }}

    <div class="mt-4">
        <x-filament::button wire:click="handleSave">
            simpan
        </x-filament::button>
    </div>
</x-filament-panels::page>
