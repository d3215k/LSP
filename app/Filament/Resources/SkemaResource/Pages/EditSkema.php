<?php

namespace App\Filament\Resources\SkemaResource\Pages;

use App\Filament\Resources\SkemaResource;
use App\Models\Asesmen;
use App\Models\Sertifikat;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditSkema extends EditRecord
{
    protected static string $resource = SkemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Terapkan Data Ke Sertifikat')
                ->requiresConfirmation()
                ->action(function () {
                    DB::beginTransaction();
                    try {
                        $ids = Asesmen::query()
                            ->where('skema_id', $this->getRecord()->id)
                            ->pluck('id');

                        Sertifikat::query()
                            ->whereIn('asesmen_id', $ids)
                            ->update([
                                'jenis' => $this->getRecord()->jenis,
                                'bidang' => $this->getRecord()->bidang,
                                'bidang_en' => $this->getRecord()->bidang_en,
                                'prefix_kompetensi' => $this->getRecord()->level_kkni,
                                'kompetensi' => $this->getRecord()->kompetensi_keahlian,
                                'kompetensi_en' => $this->getRecord()->kompetensi_keahlian_en,
                                'unit' => $this->getRecord()->unit,
                            ]);
                        DB::commit();
                        Notification::make()->title('Data Diterapkan')->success()->send();
                    } catch (\Throwable $th) {
                        $th->getMessage();
                        Notification::make()->title('Whoops! Ada yang salah')->danger()->send();
                        DB::rollBack();
                    }

                }
            ),
        ];
    }
}
