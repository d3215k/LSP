<x-filament-panels::page>
    <livewire:asesor.asesmen-mandiri.info-asesmen-mandiri-component :mandiri="$record" />
    <livewire:asesor.asesmen-mandiri.pemohon-asesmen-component lazy="on-load" :record="$record->asesmen" />
    <livewire:asesor.asesmen-mandiri.penilaian-asesmen-mandiri-component lazy="on-load" :mandiri="$record" />
</x-filament-panels::page>
