<x-layouts.cbt>
    <x-slot name="heading">
        <h1 class="text-2xl font-semibold">FR.IA.06 PERTANYAAN TERTULIS</h1>
    </x-slot>

    @if (isset($asesmen->tertulisEsai) && $asesmen->tertulisEsai?->status === \App\Enums\AsesmenTertulisStatus::MULAI)
        <livewire:asesi.cbt-esai-component :asesmenId="$asesmen->id" />
    @else
        <livewire:asesi.cbt-onboarding-tertulis-esai-component :asesmenId="$asesmen->id" />
    @endif

</x-layouts.cbt>
