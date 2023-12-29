<x-filament::section>
    <x-slot name="heading">
        Bagian 2 : Data Sertifikasi
    </x-slot>

    <x-slot name="description">
        Tuliskan Judul dan Nomor Skema Sertifikasi yang anda akan ajukan berikut Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang anda miliki.
    </x-slot>

    <form>
        {{ $this->form }}
    </form>

    <div class="mt-6">
        <h5 class="mb-6 text-sm font-medium leading-6 text-gray-950 dark:text-white">
            Daftar Unit Kompetensi
        </h5>
        {{ $this->table }}
    </div>

    <div class="mt-2">
        <x-filament::button wire:click="handleSubmit" type="submit">
            Simpan
        </x-filament::button>
    </div>

    <x-filament-actions::modals />

</x-filament::fieldset>
