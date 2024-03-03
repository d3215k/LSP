<x-filament-panels::page>

    {{ $this->persetujuanInfolist }}

    <div>
        <form wire:submit="handleSubmit" class="space-y-4">
            {{ $this->form }}

            <x-filament::fieldset class="space-y-4 text-sm">
                <div>
                    <p class="font-semibold">Asesi</p>
                    <p>Bahwa Saya Sudah Mendapatkan Penjelasan Hak dan Prosedur Banding Oleh Asesor.</p>
                </div>
                <div>
                    <p class="font-semibold">Asesor</p>
                    <p>Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai Asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.</p>
                </div>
                <div>
                    <p class="font-semibold">Asesi</p>
                    <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
                </div>

            </x-filament::fieldset>

            <x-filament::button type="submit">
                Simpan
            </x-filament::button>

        </form>

        <x-filament-actions::modals />
    </div>

</x-filament-panels::page>
