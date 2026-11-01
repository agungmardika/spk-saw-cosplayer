<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SawService;
use App\Models\Cosplayer;
use App\Models\HasilSaw;

class SawController extends Controller
{
    public function index(SawService $sawService)
    {
        $sawData = $sawService->calculate(true);

        return view('saw.index', compact('sawData'));
    }

    public function recalculate(SawService $sawService)
    {
        $sawData = $sawService->calculate(true);

        return redirect()->route('saw.index')
            ->with('swal_success', 'Perhitungan Simple Additive Weighting (SAW) berhasil diperbarui dan disimpan!');
    }

    public function perangkingan(SawService $sawService)
    {
        $sawData = $sawService->calculate(false);
        $hasilSaw = HasilSaw::with('cosplayer')->orderBy('ranking')->get();

        return view('saw.perangkingan', compact('sawData', 'hasilSaw'));
    }

    public function laporan(SawService $sawService)
    {
        $sawData = $sawService->calculate(false);
        $hasilSaw = HasilSaw::with('cosplayer')->orderBy('ranking')->get();

        return view('saw.laporan', compact('sawData', 'hasilSaw'));
    }
}
