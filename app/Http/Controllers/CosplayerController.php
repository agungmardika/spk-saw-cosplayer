<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cosplayer;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Services\SawService;
use Illuminate\Support\Facades\Storage;

class CosplayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Cosplayer::query()->with('hasilSaw');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peserta', 'like', "%{$search}%")
                  ->orWhere('no_peserta', 'like', "%{$search}%")
                  ->orWhere('nama_karakter', 'like', "%{$search}%")
                  ->orWhere('asal_series', 'like', "%{$search}%");
            });
        }

        $cosplayers = $query->orderBy('no_peserta')->paginate(10)->withQueryString();

        return view('cosplayer.index', compact('cosplayers'));
    }

    public function create()
    {
        // Generate nomor peserta otomatis
        $last = Cosplayer::orderBy('id_cosplayer', 'desc')->first();
        $nextNum = $last ? ($last->id_cosplayer + 1) : 1;
        $autoNo = 'P' . str_pad($nextNum, 2, '0', STR_PAD_LEFT);

        return view('cosplayer.create', compact('autoNo'));
    }

    public function store(Request $request, SawService $sawService)
    {
        $validated = $request->validate([
            'no_peserta' => 'required|string|max:10|unique:cosplayer,no_peserta',
            'nama_peserta' => 'required|string|max:100',
            'nama_karakter' => 'required|string|max:100',
            'asal_series' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('cosplayers', 'public');
            $validated['foto'] = $path;
        }

        $cosplayer = Cosplayer::create($validated);

        // Inisialisasi entri nilai awal 0 untuk tiap kriteria yang ada
        $kriteriaList = Kriteria::all();
        foreach ($kriteriaList as $k) {
            Penilaian::create([
                'id_cosplayer' => $cosplayer->id_cosplayer,
                'id_kriteria' => $k->id_kriteria,
                'nilai' => 0,
            ]);
        }

        $sawService->calculate(true);

        return redirect()->route('cosplayer.index')
            ->with('swal_success', "Data cosplayer {$cosplayer->nama_peserta} ({$cosplayer->no_peserta}) berhasil ditambahkan!");
    }

    public function edit(Cosplayer $cosplayer)
    {
        return view('cosplayer.edit', compact('cosplayer'));
    }

    public function update(Request $request, Cosplayer $cosplayer, SawService $sawService)
    {
        $validated = $request->validate([
            'no_peserta' => 'required|string|max:10|unique:cosplayer,no_peserta,' . $cosplayer->id_cosplayer . ',id_cosplayer',
            'nama_peserta' => 'required|string|max:100',
            'nama_karakter' => 'required|string|max:100',
            'asal_series' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($cosplayer->foto && Storage::disk('public')->exists($cosplayer->foto)) {
                Storage::disk('public')->delete($cosplayer->foto);
            }
            $path = $request->file('foto')->store('cosplayers', 'public');
            $validated['foto'] = $path;
        }

        $cosplayer->update($validated);
        $sawService->calculate(true);

        return redirect()->route('cosplayer.index')
            ->with('swal_success', "Data cosplayer {$cosplayer->nama_peserta} berhasil diperbarui!");
    }

    public function destroy(Cosplayer $cosplayer, SawService $sawService)
    {
        $nama = $cosplayer->nama_peserta;
        if ($cosplayer->foto && Storage::disk('public')->exists($cosplayer->foto)) {
            Storage::disk('public')->delete($cosplayer->foto);
        }

        $cosplayer->delete();
        $sawService->calculate(true);

        return redirect()->route('cosplayer.index')
            ->with('swal_success', "Peserta {$nama} berhasil dihapus beserta data nilainya.");
    }
}
