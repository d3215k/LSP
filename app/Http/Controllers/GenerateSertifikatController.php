<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Settings\SertifikatSetting;
use Illuminate\Http\Request;

class GenerateSertifikatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SertifikatSetting $setting, Sertifikat $record)
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin, 403);

        return view('sertifikat.generate', [
            'setting' => $setting,
            'sertifikat' => $record,
        ]);
    }
}
