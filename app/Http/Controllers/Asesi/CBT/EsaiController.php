<?php

namespace App\Http\Controllers\Asesi\CBT;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use Illuminate\Http\Request;

class EsaiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($asesmenId)
    {
        $asesmen = Asesmen::findOrFail($asesmenId);

        return view('asesi.cbt.esai', [
            'asesmen' => $asesmen
        ]);
    }
}
