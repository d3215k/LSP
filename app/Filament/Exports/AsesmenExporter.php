<?php

namespace App\Filament\Exports;

use App\Enums\AsesmenStatus;
use App\Enums\TujuanAsesmen;
use App\Models\Asesmen;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AsesmenExporter extends Exporter
{
    protected static ?string $model = Asesmen::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('asesi.kompetensiKeahlian.nama')
                ->label('Kompetensi Keahlian'),
            ExportColumn::make('periode.nama')
                ->label('Periode'),
            ExportColumn::make('skema.nama')
                ->label('Skema'),
            ExportColumn::make('asesor.nama')
                ->label('Asesor'),
            ExportColumn::make('tujuan_asesmen')
                ->state(fn (Asesmen $record) => isset($record->tujuan) ? $record->tujuan->getLabel() : '-' )
                ->label('Tujuan'),
            ExportColumn::make('status_asesmen')
                ->state(fn (Asesmen $record) => isset($record->status) ? $record->status->getLabel() : '-' )
                ->label('Status'),
            ExportColumn::make('asesi.no_reg')
                ->label('Reg'),
            ExportColumn::make('rincianDataPemohon.nama')
                ->label('Nama'),
            ExportColumn::make('rincianDataPemohon.no_identitas')
                ->label('No Identitas'),
            ExportColumn::make('rincianDataPemohon.jk')
                ->label('L/P'),
            ExportColumn::make('rincianDataPemohon.tempat_lahir')
                ->label('Tempat Lahir'),
            ExportColumn::make('rincianDataPemohon.tanggal_lahir')
                ->label('Tanggal Lahir'),
            ExportColumn::make('rincianDataPemohon.kebangsaan')
                ->label('Kebangsaan'),
            ExportColumn::make('rincianDataPemohon.alamat_rumah')
                ->label('Alamat Rumah'),
            ExportColumn::make('rincianDataPemohon.kode_pos')
                ->label('Kode Pos'),
            ExportColumn::make('rincianDataPemohon.no_telepon_rumah')
                ->label('No. Telepon Rumah'),
            ExportColumn::make('rincianDataPemohon.no_telepon_hp')
                ->label('No. Telepon HP'),
            ExportColumn::make('rincianDataPemohon.kualifikasi_pendidikan')
                ->label('Kualifikasi Pendidikan'),
            ExportColumn::make('asesi.email')
                ->label('Email'),
            ExportColumn::make('rincianDataPemohon.nama_institusi')
                ->label('Nama Institusi'),
            ExportColumn::make('rincianDataPemohon.jabatan')
                ->label('Jabatan'),
            ExportColumn::make('rincianDataPemohon.alamat_kantor')
                ->label('Alamat Kantor'),
            ExportColumn::make('rincianDataPemohon.kode_pos_kantor')
                ->label('Kode Pos Kantor'),
            ExportColumn::make('rincianDataPemohon.no_telepon_kantor')
                ->label('No. Telepon Kantor'),
            ExportColumn::make('rincianDataPemohon.no_fax_kantor')
                ->label('No. Fax Kantor'),
            ExportColumn::make('rincianDataPemohon.email_kantor')
                ->label('Email Kantor'),
            ExportColumn::make('rincianDataPemohon.tanggal_registrasi')
                ->label('Tanggal Registrasi'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data asesmen selesai dan  ' . number_format($export->successful_rows) . ' baris data di-export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal di-export.';
        }

        return $body;
    }
}
