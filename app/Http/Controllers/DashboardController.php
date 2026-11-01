<?php

namespace App\Http\Controllers;

use App\Models\Cosplayer;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilSaw;
use App\Services\SawService;

class DashboardController extends Controller
{
    public function index(SawService $sawService)
    {
        $totalCosplayer = Cosplayer::count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::count();

        // Ambil top 5 hasil SAW
        $topRanking = HasilSaw::with('cosplayer')
            ->orderBy('ranking')
            ->take(5)
            ->get();

        $kriteriaList = Kriteria::orderBy('kode_kriteria')->get();

        return view('dashboard.index', compact(
            'totalCosplayer',
            'totalKriteria',
            'totalPenilaian',
            'topRanking',
            'kriteriaList'
        ));
    }
}
