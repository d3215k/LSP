<?php

use App\Http\Controllers\Asesi\CBT\AsesmenTertulisEsaiController;
use App\Http\Controllers\GenerateSertifikatController;
use Illuminate\Support\Facades\Route;

Route::get('/asesi/{asesmen}/esai', AsesmenTertulisEsaiController::class)->middleware('auth')->name('asesi.asesmen.tertulis.esai');
Route::get('/sertifikat/{record}/generate', GenerateSertifikatController::class)->name('generate.sertifikat');
Route::redirect('/laravel/login', '/login')->name('login');
