<?php

namespace App\Observers;

use App\Models\Persyaratan;
use App\Models\Skema;

class SkemaObserver
{
    /**
     * Handle the Skema "created" event.
     */
    public function created(Skema $skema): void
    {
        $skema->persyaratan()->createMany([
            ['nama' => 'Kartu Siswa'],
            ['nama' => 'Rapor Semester 2 s/d semester 5 dengan nilai lulus semua mata pelajaran'],
            ['nama' => 'Sertifikat atau Surat Keterangan Praktik Kerja Lapangan'],
        ]);
    }

    /**
     * Handle the Skema "updated" event.
     */
    public function updated(Skema $skema): void
    {
        //
    }

    /**
     * Handle the Skema "deleted" event.
     */
    public function deleted(Skema $skema): void
    {
        //
    }

    /**
     * Handle the Skema "restored" event.
     */
    public function restored(Skema $skema): void
    {
        //
    }

    /**
     * Handle the Skema "force deleted" event.
     */
    public function forceDeleted(Skema $skema): void
    {
        //
    }
}
