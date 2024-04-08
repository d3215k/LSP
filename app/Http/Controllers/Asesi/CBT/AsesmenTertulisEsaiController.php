<?php

namespace App\Http\Controllers\Asesi\CBT;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;

class AsesmenTertulisEsaiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($asesmenId)
    {
        abort_unless(auth()->user()->isAsesi, 403);

        $asesmen = Asesmen::select('id')
            ->findOrFail($asesmenId);

        $asesmen->load('tertulisEsai:status,asesmen_id');

        return view('asesi.cbt.esai', [
            'asesmen' => $asesmen
        ]);
    }
}
