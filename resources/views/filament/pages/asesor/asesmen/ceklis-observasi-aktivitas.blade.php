<x-filament-panels::page>

    <div class="space-y-6">
        @foreach ($record->skema->unit as $unit)
            <div class="fi-ta" wire:key="{{ $unit->id }}">
                <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow-sm fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                    <div class="overflow-x-auto divide-y divide-gray-200 fi-ta-content dark:divide-white/10 dark:border-t-white/10">
                        <table class="w-full divide-y divide-gray-200 table-auto fi-ta-table text-start dark:divide-white/5">
                            <thead class="bg-gray-100 divide-y divide-gray-200 dark:bg-white/5">
                                <tr class="divide-x divide-gray-200">
                                    <th colspan="6" class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-start w-full group gap-x-1 whitespace-nowrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Unit Kompetensi 1 : {{ $unit->kode . ' ' . $unit->judul }}
                                            </span>
                                        </span>
                                    </th>
                                </tr>
                                <tr class="divide-x divide-gray-200">
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                No
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Elemen
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Kriteria Unjuk Kerja
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold flex flex-col fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                <span>Benchmark</span>
                                                <span>(SOP / spesifikasi produk industri)</span>
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                K
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                BK
                                            </span>
                                        </span>
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                @forelse ($unit->elemen as $elemen)
                                    @php $no = $loop->iteration; @endphp
                                    @foreach ($elemen->kriteriaUnjukKerja as $item)
                                    <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                        @if ($loop->first)
                                            <td rowspan="2" class="p-0 fi-ta-cell">
                                                <div class="text-center fi-ta-col-wrp">
                                                    {{ $no }}
                                                </div>
                                            </td>
                                            <td rowspan="2" class="p-0 fi-ta-cell">
                                                <div class="fi-ta-col-wrp">

                                                        <div wire:key="{{ $elemen->id }}" class="grid px-3 py-4 min-w-96 fi-ta-text gap-y-1">
                                                            <div class="text-sm fi-ta-text-item text-wrap text-gray-950 dark:text-white">
                                                                <p>
                                                                    {{ $elemen->nama }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                </div>
                                            </td>
                                        @endif

                                        <td class="p-4 border border-gray-200 fi-ta-cell">
                                            <div>
                                                <span>
                                                    {{ $item->nama }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="p-4 fi-ta-cell">
                                            <div>
                                                <span>
                                                    Benchmark
                                                </span>
                                            </div>
                                        </td>

                                        <td class="w-12 p-0  fi-ta-cell">
                                            <div class="fi-ta-col-wrp">
                                                <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                    <div class="fi-ta-text-item">
                                                        <label>
                                                            <input type="radio" class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                                id="data.kompeten.{{ $item->id }}.K"
                                                                name="data.kompeten.{{ $item->id }}"
                                                                value="K"
                                                                wire:loading.attr="disabled"
                                                                wire:model="data.kompeten.{{ $item->id }}"
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

                                        <td class="w-12 p-0  fi-ta-cell">
                                            <div class="fi-ta-col-wrp">
                                                <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                    <div class="fi-ta-text-item">
                                                        <label>
                                                            <input type="radio" class="mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                                                                id="data.kompeten.{{ $item->id }}.BK"
                                                                name="data.kompeten.{{ $item->id }}"
                                                                value="BK"
                                                                wire:loading.attr="disabled"
                                                                wire:model="data.kompeten.{{ $item->id }}"
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

                                    @endforeach
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <x-filament::button wire:click="handleSave">
            simpan
        </x-filament::button>
    </div>
</x-filament-panels::page>
