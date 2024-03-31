<?php

use App\Http\Controllers\Asesi\CBT\EsaiController;
use App\Http\Controllers\GenerateSertifikatController;
use Illuminate\Support\Facades\Route;

Route::get('/asesi/{asesmen}/esai', EsaiController::class)->name('cbt');
Route::get('/sertifikat/{record}/generate', GenerateSertifikatController::class)->name('generate.sertifikat');
Route::redirect('/laravel/login', '/login')->name('login');
