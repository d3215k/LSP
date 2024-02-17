<?php

namespace App\Filament\Resources\AsesiResource\Pages;

use App\Filament\Resources\AsesiResource;
use App\Models\KompetensiKeahlian;
use App\Support\GenerateNumber;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsesi extends CreateRecord
{
    protected static string $resource = AsesiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $kode = KompetensiKeahlian::query()
            ->withoutGlobalScopes()
            ->where('id', $data['kompetensi_keahlian_id'])
            ->first()?->reg;

        $data['no_reg'] = GenerateNumber::registrasi($kode);

        return $data;
    }
}
