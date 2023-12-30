<?php

namespace App\Filament\Pages\Asesor;

use Filament\Pages\Page;

use App\Enums\AsesmenStatus;
use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use App\Models\Asesmen\Mandiri;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Actions\ActionGroup;
class LaporanAsesmenPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asesor.laporan-asesmen-page';

    protected static ?string $title = 'Laporan Asesmen';

    protected static ?string $slug = 'asesor/laporan-asesmen';

    protected static ?string $navigationGroup = 'Asesor';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAsesor;
    }

    public function mount()
    {
        if (! auth()->user()->isAsesor) {
            return to_route('filament.app.pages.beranda');
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Asesmen::query()
                ->whereIn('status', [AsesmenStatus::SELESAI_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN, AsesmenStatus::SELESAI_BELUM_KOMPETEN_PERLU_TINDAK_LANJUT])
                ->where('asesor_id', auth()->user()->asesor_id),
            )
            ->columns([
                TextColumn::make('rincianDataPemohon.nama')
                    ->label('Asesi / Skema')
                    ->description(fn (Asesmen $record): string => $record->skema->nama),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
