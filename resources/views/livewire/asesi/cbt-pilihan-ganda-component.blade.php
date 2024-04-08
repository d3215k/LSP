<div class="grid grid-cols-1 gap-4 md:grid-cols-12">
    <div class="bg-white md:col-span-9 shadow-sm overflow-hidden rounded-lg">
        <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50 flex justify-between items-center">
            <h3 class="text-xl font-semibold">Soal No. {{ $selectedPertanyaan + 1 }}</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="text-wrap">
                <div class="fi-ta-col-wrp max-w-screen-lg prose dark:prose-invert bg-white dark:bg-gray-900">
                    {!! $this->pertanyaan->pertanyaan !!}
                </div>

            </div>
            @foreach ($this->pertanyaan->pilihanJawaban as $pilihanJawaban)
            <div class="flex items-center gap-x-3">
                <input
                    id="pilihan-jawaban.{{ $pilihanJawaban->id }}"
                    name="pilihan-jawaban.{{ $pilihanJawaban->id }}"
                    type="radio"
                    wire:loading.attr="disabled"
                    wire:model="data.pilihan_jawaban_id"
                    value="{{ $pilihanJawaban->id }}"
                    class="h-4 w-4 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                />
                <label for="pilihan-jawaban.{{ $pilihanJawaban->id }}" class="block max-w-screen-xs prose dark:prose-invert bg-white dark:bg-gray-900">
                    {!! $pilihanJawaban->jawaban !!}
                </label>
            </div>
            @endforeach

            {{-- <div>
                {{ $this->form }}
            </div> --}}

        </div>
        <div class="flex items-center p-6 justify-between">
            @if ($selectedPertanyaan !== 0)
            <x-filament::button wire:click="prev" icon="heroicon-m-chevron-left">
                Sebelumnya
            </x-filament::button>
            @endif

            @if ((int) $this->selectedPertanyaan === count($this->pertanyaanPilihanGanda) - 1)
                {{ $this->finishAction }}
            @else
                <x-filament::button wire:click="next" icon="heroicon-m-chevron-right" icon-position="after">
                    Selanjutnya
                </x-filament::button>
            @endif
        </div>
    </div>

    <div class="md:col-span-3">
        <div class="bg-white shadow-sm overflow-hidden rounded-lg">
            <div wire:ignore>
                <div class="bg-gray-50 px-5 py-2 dark:bg-gray-700/50 flex justify-between items-center">
                    <h3 class="font-semibold">Waktu Tersisa</h3>
                </div>
                <div class="px-5">
                    <span class="text-danger-600 font-semibold text-lg" id="timer"></span>
                </div>
            </div>
            <div class="mt-4">
                <div class="bg-gray-50 px-5 dark:bg-gray-700/50 flex justify-between items-center">
                    <h3 class="font-semibold">Daftar Soal</h3>
                </div>
                <div class="grid grid-cols-10 md:grid-cols-3 lg:grid-cols-5 gap-2 p-4">
                    @foreach ($this->pertanyaanPilihanGanda as $pertanyaan)
                        <x-filament::button  color="{{ array_key_exists($pertanyaan->id, $this->jawabanTertulisPilihanGanda) ? 'primary' : 'gray' }}" wire:key="{{ $pertanyaan->id }}" wire:click="next('{{ $loop->index }}')">
                            {{ $loop->index + 1 }}
                        </x-filament::button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-filament-actions::modals />

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $this->tertulisPilihanGanda->created_at->addMinutes($this->asesmen->skema->durasi_tertulis_pilihan_ganda) }}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for hours, minutes, and seconds
            var hours = Math.floor(distance / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Pad single digit values with leading zeros
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            // Display the result in the element with id="timer"
            document.getElementById("timer").innerHTML = hours + ":" + minutes + ":" + seconds;

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "HABIS";
                Livewire.dispatch('timeup');
            }

        }, 1000);
    </script>
</div>
