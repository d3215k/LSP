<x-filament-panels::page>

    <div class="space-y-6">
        @foreach ($record->skema->unit as $unit)
            @if ($unit->pertanyaanTertulisEsai->count() > 0)
                <div class="space-y-4 fi-ta" wire:key="unit-asesmen-{{ $unit->id }}">
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

                    <div class="overflow-hidden bg-white divide-y divide-gray-200 fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
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
                                                    Pertanyaan
                                                </span>
                                            </span>
                                        </th>
                                        <th class="px-3 py-2 min-w-36">
                                            <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                                <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                    Jawab
                                                </span>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                                    @foreach ($unit->pertanyaanTertulisEsai as $pertanyaan)
                                        <div wire:key="pertanyaan-asesmen-{{ $pertanyaan->id }}">
                                            <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                                <td class="p-0 fi-ta-cell">
                                                    <div class="text-center fi-ta-col-wrp">
                                                        {{ $loop->iteration; }}
                                                    </div>
                                                </td>
                                                <td class="border-l border-gray-200 text-wrap fi-ta-cell">
                                                    <div class="text-wrap">
                                                        <div class="fi-ta-col-wrp max-w-screen-lg p-4 prose dark:prose-invert bg-white dark:bg-gray-900">
                                                            {!! $pertanyaan->pertanyaan !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-4 border-l border-gray-200 text-wrap fi-ta-cell">
                                                    <div class="text-center">
                                                        {{ ($this->jawabAction)([
                                                            'pertanyaanId' => $pertanyaan->id,
                                                            'pertanyaan' => $pertanyaan->pertanyaan,
                                                            'jawaban' => $jawaban[$pertanyaan->id] ?? '',
                                                        ]) }}
                                                    </div>
                                                </td>
                                            </tr>
                                            @isset($jawaban[$pertanyaan->id])
                                                <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                                    <td x-data="{ open: true }" colspan="4" class="fi-ta-cell">
                                                        <button class="bg-success-100 dark:bg-success-800 py-2 px-4 w-full text-left font-medium text-sm" x-on:click="open = ! open">
                                                            Jawaban No. {{ $loop->iteration }}
                                                        </button>
                                                        <div x-show="open" class="fi-ta-col-wrp max-w-screen-lg p-4 prose dark:prose-invert bg-white dark:bg-gray-900">
                                                            {!! $jawaban[$pertanyaan->id] ?? '' !!}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endisset
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</x-filament-panels::page>
