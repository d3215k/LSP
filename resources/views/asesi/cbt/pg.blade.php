<x-layouts.cbt>
    <x-slot name="heading">
        <h1 class="text-2xl font-semibold">FR.IA.05 PERTANYAAN TERTULIS PILIHAN GANDA</h1>
    </x-slot>

    @if (isset($asesmen->tertulisPilihanGanda) && $asesmen->tertulisPilihanGanda?->status === \App\Enums\AsesmenTertulisStatus::MULAI)
        <livewire:asesi.cbt-pilihan-ganda-component :asesmenId="$asesmen->id" />
    @else
        <livewire:asesi.cbt-onboarding-tertulis-pilihan-ganda-component :asesmenId="$asesmen->id" />
    @endif

</x-layouts.cbt>
