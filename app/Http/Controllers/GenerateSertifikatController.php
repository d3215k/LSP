<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class GenerateSertifikatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Sertifikat $record)
    {
        return view('sertifikat.generate', [
            'sertifikat' => $record,
        ]);
    }
}
