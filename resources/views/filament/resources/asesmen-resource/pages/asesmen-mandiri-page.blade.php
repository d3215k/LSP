<x-filament-panels::page>
    @if ($isShow)
        <livewire:asesor.asesmen-mandiri.info-asesmen-mandiri-component :mandiri="$this->getRecord()->mandiri" />
        <livewire:asesor.asesmen-mandiri.pemohon-asesmen-component lazy="on-load" :record="$this->getRecord()" />
        <livewire:asesor.asesmen-mandiri.penilaian-asesmen-mandiri-component lazy="on-load" :mandiri="$this->getRecord()->mandiri" />
    @else
        <div class="text-gray-400 text-md text-center">
            Asesi Belum mengisi Asesmen Mandiri
        </div>
    @endif
</x-filament-panels::page>
