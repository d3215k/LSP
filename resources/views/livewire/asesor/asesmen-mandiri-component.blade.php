<div>
    <div class="space-y-6">
        @foreach ($mandiri->asesmen->skema->unit as $unit)
            <div class="fi-ta" wire:key="{{ $unit->id }}">
                <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow-sm fi-ta-ctn ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                    <div class="overflow-x-auto divide-y divide-gray-200 fi-ta-content dark:divide-white/10 dark:border-t-white/10">
                        <table class="w-full divide-y divide-gray-200 table-auto fi-ta-table text-start dark:divide-white/5">
                            <thead class="bg-gray-100 divide-y divide-gray-200 dark:bg-white/5">
                                <tr class="divide-x divide-gray-200">
                                    <th colspan="4" class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-start w-full group gap-x-1 whitespace-nowrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Unit Kompetensi {{ $loop->iteration }} : {{ $unit->kode . ' ' . $unit->judul }}
                                            </span>
                                        </span>
                                    </th>
                                </tr>
                                <tr class="divide-x divide-gray-200">
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-start w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Dapatkah saya ... ?
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-wrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Keterangan
                                            </span>
                                        </span>
                                    </th>
                                    <th class="px-3 py-2 fi-ta-header-cell sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                        <span class="flex items-center justify-center w-full group gap-x-1 whitespace-nowrap">
                                            <span class="text-sm font-semibold fi-ta-header-cell-label text-gray-950 dark:text-white">
                                                Bukti Yang Relevan
                                            </span>
                                        </span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                <tr class="divide-x divide-gray-200 fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
                                    <td class="p-0 fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                        <div class="fi-ta-col-wrp">
                                            @forelse ($unit->elemen as $elemen)
                                                <div wire:key="{{ $elemen->id }}" class="grid px-3 py-4 min-w-96 fi-ta-text gap-y-1">
                                                    <div class="text-sm fi-ta-text-item text-wrap text-gray-950 dark:text-white">
                                                        <p class="font-bold">
                                                            {{ $loop->iteration }}. Elemen : {{ $elemen->nama }}
                                                        </p>
                                                        <p class="pl-4 mt-2 text-xs font-semibold uppercase text-primary-600">Kriteria Unjuk Kerja</p>
                                                        <ol>
                                                            @php
                                                                $no = $loop->iteration
                                                            @endphp
                                                            @forelse ($elemen->kuk as $kuk)
                                                                <li class="flex gap-1" wire:key="{{ $kuk->id }}">
                                                                    <div class="w-10 text-right">{{ $no }}.{{ $loop->iteration }}</div>
                                                                    <div class="flex-1">
                                                                        {{ $kuk->nama }}
                                                                    </div>
                                                                </li>
                                                            @empty

                                                            @endforelse

                                                        </ol>
                                                    </div>
                                                </div>
                                            @empty

                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="p-0 fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                        <div class="fi-ta-col-wrp">
                                            <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                <div class="fi-ta-text-item">
                                                    <span @class([
                                                        '',
                                                        'text-success-600' => $data['kompeten'][$unit->id] === 'K',
                                                        'text-danger-600' => $data['kompeten'][$unit->id] === 'BK'
                                                    ])>
                                                        {{ $data['kompeten'][$unit->id] === 'K' ? 'Kompeten' : 'Belum Kompeten' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-0 fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                        <div class="px-2 fi-ta-col-wrp">
                                            <div class="flex justify-center w-full disabled:pointer-events-none text-start">
                                                <div class="fi-ta-text-item">
                                                    @if ($data['bukti'][$unit->id])
                                                        <a target="_blank" href="{{ asset('storage/'.$data['bukti'][$unit->id]->file) }}" class="text-primary-600">
                                                            {{ $data['bukti'][$unit->id]->nama }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
