<div>
    <div class="bg-white md:col-span-9 shadow-sm overflow-hidden rounded-lg">
        <div class="bg-gray-50 px-5 py-4 dark:bg-gray-700/50 flex justify-between items-center">
            <h3 class="text-xl font-semibold">Status Pengerjaan</h3>
        </div>
        <div class="p-6 space-y-6">
            {{ $this->asesmenInfolist }}

            @if (!isset($this->asesmen->tertulisPilihanGanda))
            {{ $this->startAction }}
            @endif

            <x-filament-actions::modals />
        </div>
    </div>
</div>
