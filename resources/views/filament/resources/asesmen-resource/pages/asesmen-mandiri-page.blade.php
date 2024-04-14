<x-filament-panels::page>
    <livewire:asesor.asesmen-mandiri.info-asesmen-mandiri-component :mandiri="$this->getRecord()->mandiri" />
    <livewire:asesor.asesmen-mandiri.pemohon-asesmen-component lazy="on-load" :record="$this->getRecord()" />
    <livewire:asesor.asesmen-mandiri.penilaian-asesmen-mandiri-component lazy="on-load" :mandiri="$this->getRecord()->mandiri" />
</x-filament-panels::page>
