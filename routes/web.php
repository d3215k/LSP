<?php

use App\Http\Controllers\GenerateSertifikatController;
use App\Livewire\Asesi\AsesmenMandiriPage;
use App\Livewire\Asesi\AsesmenTertulisEsaiPage;
use App\Livewire\Asesi\AsesmenTertulisPilihanGandaPage;
use App\Livewire\Asesi\BandingAsesmenPage;
use App\Livewire\Asesi\BerandaPage;
use App\Livewire\Asesi\PermohonanSertifikasiKompetensiPage;
use App\Livewire\Asesi\UmpanBalikDanCatatanAsesmenPage;
use Illuminate\Support\Facades\Route;

Route::get('/me', BerandaPage::class)->middleware('auth')->name('asesi.beranda');
Route::get('/asesi/{asesmen}/permohonan', PermohonanSertifikasiKompetensiPage::class)->middleware('auth')->name('asesi.permohonan.asesmen');
Route::get('/asesi/{asesmen}/fr-apl-02-asesmen-mandiri', AsesmenMandiriPage::class)->middleware('auth')->name('asesi.asesmen.mandiri');
Route::get('/asesi/{asesmen}/fr-ak-03-umpan-balik-dan-catatan-asesmen', UmpanBalikDanCatatanAsesmenPage::class)->middleware('auth')->name('asesi.umpan.balik.dan.catatan.asesmen');
Route::get('/asesi/{asesmen}/fr-ak-04-banding-asesmen', BandingAsesmenPage::class)->middleware('auth')->name('asesi.banding.asesmen');
Route::get('/asesi/{asesmen}/esai', AsesmenTertulisEsaiPage::class)->middleware('auth')->name('asesi.asesmen.tertulis.esai');
Route::get('/asesi/{asesmen}/pg', AsesmenTertulisPilihanGandaPage::class)->middleware('auth')->name('asesi.asesmen.tertulis.pilihan.ganda');
Route::get('/sertifikat/{record}/generate', GenerateSertifikatController::class)->name('generate.sertifikat');
Route::redirect('/laravel/login', '/login')->name('login');
