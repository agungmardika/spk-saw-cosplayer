<?php

namespace App\Services;

use App\Models\Cosplayer;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\HasilSaw;

class SawService
{
    /**
     * Calculate SAW and return detailed calculation steps and results.
     */
    public function calculate(bool $saveToDatabase = true): array
    {
        $kriteriaList = Kriteria::orderBy('kode_kriteria')->get();
        $cosplayerList = Cosplayer::orderBy('no_peserta')->get();

        if ($kriteriaList->isEmpty() || $cosplayerList->isEmpty()) {
            return [
                'hasData' => false,
                'kriteria' => $kriteriaList,
                'cosplayer' => $cosplayerList,
                'matriksKeputusan' => [],
                'maxMin' => [],
                'maxValues' => [],
                'maxKriteria' => [],
                'minValues' => [],
                'matriksNormalisasi' => [],
                'preferensi' => [],
                'ranking' => [],
                'hasilRanking' => [],
            ];
        }

        // 1. Matriks Keputusan (X)
        $penilaian = Penilaian::all();
        $penilaianMap = [];
        foreach ($penilaian as $p) {
            $penilaianMap[$p->id_cosplayer][$p->id_kriteria] = (float)$p->nilai;
        }

        $matriksKeputusan = [];
        foreach ($cosplayerList as $coser) {
            $row = [
                'cosplayer' => $coser,
                'scores' => [],
            ];
            foreach ($kriteriaList as $k) {
                $row['scores'][$k->id_kriteria] = $penilaianMap[$coser->id_cosplayer][$k->id_kriteria] ?? 0;
            }
            $matriksKeputusan[$coser->id_cosplayer] = $row;
        }

        // 2. Cari Nilai Max / Min per Kriteria
        $maxValues = [];
        $minValues = [];
        foreach ($kriteriaList as $k) {
            $colValues = [];
            foreach ($cosplayerList as $coser) {
                $colValues[] = $matriksKeputusan[$coser->id_cosplayer]['scores'][$k->id_kriteria] ?? 0;
            }
            $maxValues[$k->id_kriteria] = !empty($colValues) ? max($colValues) : 0;
            $minValues[$k->id_kriteria] = !empty($colValues) ? min($colValues) : 0;
        }

        // 3. Matriks Normalisasi (R)
        $matriksNormalisasi = [];
        foreach ($cosplayerList as $coser) {
            $rowNorm = [
                'cosplayer' => $coser,
                'r' => [],
            ];
            foreach ($kriteriaList as $k) {
                $x_ij = $matriksKeputusan[$coser->id_cosplayer]['scores'][$k->id_kriteria] ?? 0;
                $max_j = $maxValues[$k->id_kriteria];
                $min_j = $minValues[$k->id_kriteria];

                if (strtolower($k->jenis) === 'cost') {
                    $r_ij = ($x_ij > 0) ? ($min_j / $x_ij) : 0;
                } else {
                    // Benefit
                    $r_ij = ($max_j > 0) ? ($x_ij / $max_j) : 0;
                }

                $rowNorm['r'][$k->id_kriteria] = round($r_ij, 4);
            }
            $matriksNormalisasi[$coser->id_cosplayer] = $rowNorm;
        }

        // 4. Hitung Nilai Preferensi (V_i = sum(w_j * r_ij))
        $preferensi = [];
        foreach ($cosplayerList as $coser) {
            $v_i = 0.0;
            $detailHitung = [];
            foreach ($kriteriaList as $k) {
                $w_j = (float)$k->bobot;
                $r_ij = $matriksNormalisasi[$coser->id_cosplayer]['r'][$k->id_kriteria] ?? 0;
                $subtotal = $w_j * $r_ij;
                $v_i += $subtotal;
                $detailHitung[$k->id_kriteria] = [
                    'bobot' => $w_j,
                    'r' => $r_ij,
                    'subtotal' => round($subtotal, 4),
                ];
            }
            $preferensi[$coser->id_cosplayer] = [
                'cosplayer' => $coser,
                'v_i' => round($v_i, 4),
                'detail' => $detailHitung,
            ];
        }

        // 5. Perangkingan (Urutkan dari nilai preferensi terbesar ke terkecil)
        $rankingList = array_values($preferensi);
        usort($rankingList, function ($a, $b) {
            if ($b['v_i'] == $a['v_i']) {
                return 0;
            }
            return ($b['v_i'] > $a['v_i']) ? 1 : -1;
        });

        // Berikan nomor peringkat
        $rank = 1;
        $rankingResults = [];
        foreach ($rankingList as $item) {
            $item['ranking'] = $rank++;
            $item['total_nilai'] = $item['v_i'];
            $rankingResults[] = $item;
        }

        // Simpan ke database jika diminta
        if ($saveToDatabase) {
            HasilSaw::truncate();
            foreach ($rankingResults as $res) {
                HasilSaw::create([
                    'id_cosplayer' => $res['cosplayer']->id_cosplayer,
                    'total_nilai' => $res['v_i'],
                    'ranking' => $res['ranking'],
                ]);
            }
        }

        return [
            'hasData' => true,
            'kriteria' => $kriteriaList,
            'cosplayer' => $cosplayerList,
            'matriksKeputusan' => $matriksKeputusan,
            'maxValues' => $maxValues,
            'maxKriteria' => $maxValues,
            'minValues' => $minValues,
            'matriksNormalisasi' => $matriksNormalisasi,
            'preferensi' => $preferensi,
            'ranking' => $rankingResults,
            'hasilRanking' => $rankingResults,
        ];
    }
}
