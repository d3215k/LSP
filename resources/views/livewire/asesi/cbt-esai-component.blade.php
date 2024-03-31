<div class="grid grid-cols-1 gap-4 md:grid-cols-12">
    <div class="bg-white md:col-span-9 shadow-sm overflow-hidden rounded-lg">
        <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50 flex justify-between items-center">
            <h3 class="text-xl font-semibold">Soal No. {{ $selectedPertanyaan + 1 }}</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="text-wrap">
                <div class="fi-ta-col-wrp max-w-screen-lg prose dark:prose-invert bg-white dark:bg-gray-900">
                    {!! $pertanyaan->pertanyaan !!}
                </div>
            </div>

            <div>
                {{ $this->form }}
            </div>

            <div class="flex items-center justify-between">
                @if ($selectedPertanyaan !== 0)
                <x-filament::button wire:click="prev" icon="heroicon-m-chevron-left">
                    Sebelumnya
                </x-filament::button>
                @endif

                @if ((int) $this->selectedPertanyaan === count($this->pertanyaanEsai) - 1)
                <x-filament::button wire:click="finish" icon="heroicon-m-check" icon-position="after">
                    Selesai
                </x-filament::button>
                @else
                <x-filament::button wire:click="next" icon="heroicon-m-chevron-right" icon-position="after">
                    Selanjutnya
                </x-filament::button>
                @endif
            </div>

        </div>
    </div>

    <div class="md:col-span-3">
        <div class="bg-white shadow-sm overflow-hidden rounded-lg">
            <div wire:ignore>
                <div class="bg-gray-50 px-5 py-2 dark:bg-gray-700/50 flex justify-between items-center">
                    <h3 class="font-semibold">Time Left</h3>
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
                    @foreach ($this->pertanyaanEsai as $pertanyaan)
                        <x-filament::button  color="{{ $pertanyaan->dijawab ? 'primary' : 'gray' }}" wire:key="{{ $pertanyaan->id }}" wire:click="next('{{ $loop->index }}')">
                            {{ $loop->index + 1 }}
                        </x-filament::button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $this->tertulisEsai->created_at->addMinutes(300) }}").getTime();

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
        }
        }, 1000);
    </script>
</div>
