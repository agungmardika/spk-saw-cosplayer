<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Services\SawService;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $totalBobot = $kriteria->sum('bobot');

        return view('kriteria.index', compact('kriteria', 'totalBobot'));
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria, SawService $sawService)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:50',
            'bobot' => 'required|numeric|min:0.01|max:1',
            'jenis' => 'required|string|in:benefit,cost',
        ]);

        $kriteria->update($validated);
        $sawService->calculate(true);

        return redirect()->route('kriteria.index')
            ->with('swal_success', "Kriteria {$kriteria->kode_kriteria} ({$kriteria->nama_kriteria}) berhasil diperbarui!");
    }

    public function resetDefault(SawService $sawService)
    {
        $defaults = [
            'C1' => ['nama' => 'Detail Kostum', 'bobot' => 0.30, 'jenis' => 'benefit'],
            'C2' => ['nama' => 'Aksi Panggung', 'bobot' => 0.25, 'jenis' => 'benefit'],
            'C3' => ['nama' => 'Make Up/Rias Wajah', 'bobot' => 0.20, 'jenis' => 'benefit'],
            'C4' => ['nama' => 'Penjiwaan Karakter', 'bobot' => 0.25, 'jenis' => 'benefit'],
        ];

        foreach ($defaults as $kode => $val) {
            Kriteria::where('kode_kriteria', $kode)->update([
                'nama_kriteria' => $val['nama'],
                'bobot' => $val['bobot'],
                'jenis' => $val['jenis'],
            ]);
        }

        $sawService->calculate(true);

        return redirect()->route('kriteria.index')
            ->with('swal_success', 'Bobot kriteria berhasil dikembalikan ke standar default (Total: 1.00)!');
    }
}
