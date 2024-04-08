<?php

namespace App\Http\Controllers\Asesi\CBT;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;

class AsesmenTertulisPilihanGandaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($asesmenId)
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $asesmen = Asesmen::findOrFail((int) $asesmenId);

        $asesmen->load('tertulisPilihanGanda');

        return view('asesi.cbt.pg', [
            'asesmen' => $asesmen
        ]);
    }
}
