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

    <x-filament::fieldset class="mt-4">

    <x-slot name="label">
        Daftar Unit Kompetensi
    </x-slot>

    <div>
        {{ $this->table }}
    </div>

    </x-filament::fieldset>

    <div class="mt-2">
        <x-filament::button wire:click="handleSubmit" type="submit">
            Simpan
        </x-filament::button>
    </div>

    <x-filament-actions::modals />

</x-filament::fieldset>
