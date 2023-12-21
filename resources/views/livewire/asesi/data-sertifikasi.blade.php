<x-filament::section>
    <x-slot name="heading">
        Bagian 2 : Data Sertifikasi
    </x-slot>

    <x-slot name="description">
        Tuliskan Judul dan Nomor Skema Sertifikasi yang anda akan ajukan berikut Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang anda miliki.
    </x-slot>

    <form wire:submit="save">

        {{ $this->form }}

        <x-filament::button type="submit" class="mt-2">
            Submit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />

</x-filament::section>
