<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cosplayer;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Services\SawService;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $query = Cosplayer::query()->with('penilaian');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peserta', 'like', "%{$search}%")
                  ->orWhere('no_peserta', 'like', "%{$search}%")
                  ->orWhere('nama_karakter', 'like', "%{$search}%");
            });
        }

        $cosplayers = $query->orderBy('no_peserta')->get();

        // Siapkan matriks nilai
        $penilaianMap = [];
        foreach (Penilaian::all() as $p) {
            $penilaianMap[$p->id_cosplayer][$p->id_kriteria] = (float)$p->nilai;
        }

        return view('penilaian.index', compact('cosplayers', 'kriteria', 'penilaianMap'));
    }

    public function edit(Cosplayer $cosplayer)
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $existingNilai = [];
        foreach ($cosplayer->penilaian as $p) {
            $existingNilai[$p->id_kriteria] = $p->nilai;
        }

        return view('penilaian.edit', compact('cosplayer', 'kriteria', 'existingNilai'));
    }

    public function update(Request $request, Cosplayer $cosplayer, SawService $sawService)
    {
        $kriteria = Kriteria::all();
        $rules = [];
        foreach ($kriteria as $k) {
            $rules["nilai.{$k->id_kriteria}"] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        foreach ($request->input('nilai', []) as $id_kriteria => $nilai) {
            Penilaian::updateOrCreate(
                [
                    'id_cosplayer' => $cosplayer->id_cosplayer,
                    'id_kriteria' => $id_kriteria,
                ],
                [
                    'nilai' => (float)$nilai,
                ]
            );
        }

        $sawService->calculate(true);

        return redirect()->route('penilaian.index')
            ->with('swal_success', "Penilaian untuk {$cosplayer->nama_peserta} ({$cosplayer->no_peserta}) berhasil disimpan!");
    }

    public function storeOrUpdate(Request $request, SawService $sawService)
    {
        $request->validate([
            'id_cosplayer' => 'required|exists:cosplayer,id_cosplayer',
        ]);

        $cosplayer = Cosplayer::findOrFail($request->id_cosplayer);

        $kriteria = Kriteria::all();
        $rules = [];
        foreach ($kriteria as $k) {
            $rules["nilai.{$k->id_kriteria}"] = 'required|numeric|min:0|max:100';
        }
        $request->validate($rules);

        foreach ($request->input('nilai', []) as $id_kriteria => $nilai) {
            Penilaian::updateOrCreate(
                [
                    'id_cosplayer' => $cosplayer->id_cosplayer,
                    'id_kriteria' => $id_kriteria,
                ],
                [
                    'nilai' => (float)$nilai,
                ]
            );
        }

        $sawService->calculate(true);

        return redirect()->route('penilaian.index')
            ->with('swal_success', "Penilaian untuk {$cosplayer->nama_peserta} ({$cosplayer->no_peserta}) berhasil disimpan!");
    }
}
