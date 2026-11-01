@extends('layouts.app')

@section('title', 'Perhitungan SAW')
@section('page_title', 'Perhitungan SAW')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 mb-1.5">
                <i class="fa-solid fa-square-root-variable text-[11px]"></i>
                Algoritma Simple Additive Weighting
            </div>
            <h1 class="text-lg sm:text-xl font-bold text-slate-900">
                Tahapan Perhitungan Metode SAW
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Proses normalisasi dan pembobotan kriteria secara terperinci sesuai metode Simple Additive Weighting.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <form action="{{ route('saw.recalculate') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
                    <i class="fa-solid fa-arrows-rotate"></i>
                    <span>Hitung Ulang SAW</span>
                </button>
            </form>
            <a href="{{ route('saw.ranking') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                <i class="fa-solid fa-ranking-star text-blue-600"></i>
                <span>Form Perangkingan</span>
            </a>
            <a href="{{ route('saw.laporan') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>

    @if(!$sawData['hasData'])
        <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-500 text-sm">
            Data peserta cosplayer atau kriteria belum lengkap. Silakan lengkapi data peserta dan nilai juri terlebih dahulu.
        </div>
    @else

        <!-- TAHAP 1: MATRIKS KEPUTUSAN (X) -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-lg bg-blue-600 text-white text-xs flex items-center justify-center font-bold">1</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900">
                            Tahap 1: Matriks Keputusan ($X$)
                        </h3>
                        <p class="text-xs text-slate-500">Nilai mentah setiap alternatif ($A_i$) terhadap setiap kriteria ($C_j$).</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200">
                    Dimensi [{{ count($sawData['cosplayer']) }} &times; {{ count($sawData['kriteria']) }}]
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                            <th class="py-3 px-4 text-center w-14">No</th>
                            <th class="py-3 px-4 w-24">Alternatif</th>
                            <th class="py-3 px-4">Nama Cosplayer</th>
                            @foreach($sawData['kriteria'] as $k)
                                <th class="py-3 px-4 text-center">
                                    <div>{{ $k->nama_kriteria }}</div>
                                    <div class="text-[10px] text-slate-500 font-normal font-mono">({{ $k->kode_kriteria }})</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($sawData['cosplayer'] as $index => $coser)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-2.5 px-4 text-center text-slate-500 font-mono">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-4 font-mono font-semibold text-blue-700">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200">{{ $coser->no_peserta }}</span>
                                </td>
                                <td class="py-2.5 px-4 font-medium text-slate-900">{{ $coser->nama_peserta }}</td>
                                @foreach($sawData['kriteria'] as $k)
                                    <td class="py-2.5 px-4 text-center font-mono font-semibold text-slate-800">
                                        {{ $sawData['matriksKeputusan'][$coser->id_cosplayer]['scores'][$k->id_kriteria] ?? 0 }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <!-- Footer: Nilai Max -->
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50 font-semibold font-mono text-xs">
                            <td colspan="3" class="py-3 px-4 text-right text-slate-700 uppercase">
                                Nilai Maksimum ($\max X_{ij}$):
                            </td>
                            @foreach($sawData['kriteria'] as $k)
                                <td class="py-3 px-4 text-center text-blue-700 text-sm font-bold">
                                    {{ $sawData['maxValues'][$k->id_kriteria] ?? $sawData['maxKriteria'][$k->id_kriteria] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- TAHAP 2: NORMALISASI MATRIKS (R) -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-lg bg-blue-600 text-white text-xs flex items-center justify-center font-bold">2</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900">
                            Tahap 2: Matriks Ternormalisasi ($R$)
                        </h3>
                        <p class="text-xs text-slate-500">
                            Rumus Kriteria Benefit: $r_{ij} = \frac{x_{ij}}{\max(x_{ij})}$. Seluruh nilai berada pada rentang 0 s.d. 1.
                        </p>
                    </div>
                </div>
                <span class="text-xs font-mono text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded border border-emerald-200">
                    Normalisasi Benefit
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                            <th class="py-3 px-4 text-center w-14">No</th>
                            <th class="py-3 px-4 w-24">Alternatif</th>
                            <th class="py-3 px-4">Nama Cosplayer</th>
                            @foreach($sawData['kriteria'] as $k)
                                <th class="py-3 px-4 text-center">
                                    <div>{{ $k->nama_kriteria }}</div>
                                    <div class="text-[10px] text-slate-500 font-normal font-mono">({{ $k->kode_kriteria }})</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($sawData['cosplayer'] as $index => $coser)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-2.5 px-4 text-center text-slate-500 font-mono">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-4 font-mono font-semibold text-blue-700">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200">{{ $coser->no_peserta }}</span>
                                </td>
                                <td class="py-2.5 px-4 font-medium text-slate-900">{{ $coser->nama_peserta }}</td>
                                @foreach($sawData['kriteria'] as $k)
                                    @php
                                        $normVal = $sawData['matriksNormalisasi'][$coser->id_cosplayer][$k->id_kriteria] ?? 0;
                                    @endphp
                                    <td class="py-2.5 px-4 text-center font-mono font-semibold text-slate-800">
                                        {{ number_format($normVal, 4) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <!-- Footer: Bobot Kriteria -->
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50 font-semibold font-mono text-xs">
                            <td colspan="3" class="py-3 px-4 text-right text-slate-700 uppercase">
                                Bobot Preferensi ($W_j$):
                            </td>
                            @foreach($sawData['kriteria'] as $k)
                                <td class="py-3 px-4 text-center text-blue-700 text-sm font-bold">
                                    {{ number_format($k->bobot, 2) }} ({{ $k->bobot * 100 }}%)
                                </td>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- TAHAP 3: NILAI PREFERENSI (V) & PERANGKINGAN -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-lg bg-blue-600 text-white text-xs flex items-center justify-center font-bold">3</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900">
                            Tahap 3: Perhitungan Nilai Preferensi ($V_i$) & Perangkingan
                        </h3>
                        <p class="text-xs text-slate-500">
                            Perkalian bobot dengan matriks normalisasi: $V_i = \sum_{j=1}^{n} (w_j \times r_{ij})$.
                        </p>
                    </div>
                </div>
                <a href="{{ route('saw.ranking') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Buka Tampilan Form Perangkingan &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                            <th class="py-3 px-4 text-center w-20">Peringkat</th>
                            <th class="py-3 px-4 w-24">No. Peserta</th>
                            <th class="py-3 px-4">Nama Peserta</th>
                            <th class="py-3 px-4">Karakter / Series</th>
                            <th class="py-3 px-4 text-center w-36">Nilai Akhir (Vi)</th>
                            <th class="py-3 px-4 text-center w-28">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @php
                            $rankingItems = $sawData['ranking'] ?? $sawData['hasilRanking'] ?? [];
                        @endphp
                        @foreach($rankingItems as $item)
                            @php
                                $rank = $item['ranking'];
                                $rankBadge = match($rank) {
                                    1 => 'bg-amber-100 text-amber-800 border-amber-300 font-bold',
                                    2 => 'bg-slate-100 text-slate-800 border-slate-300 font-bold',
                                    3 => 'bg-orange-100 text-orange-800 border-orange-300 font-bold',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                                $scoreVal = $item['total_nilai'] ?? $item['v_i'] ?? 0;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs border {{ $rankBadge }}">
                                        @if($rank <= 3)
                                            Juara {{ $rank }}
                                        @else
                                            #{{ $rank }}
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-mono font-semibold text-blue-700">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200">{{ $item['cosplayer']->no_peserta }}</span>
                                </td>
                                <td class="py-3 px-4 font-semibold text-slate-900">
                                    {{ $item['cosplayer']->nama_peserta }}
                                </td>
                                <td class="py-3 px-4 text-slate-600 text-xs">
                                    <span class="font-medium text-slate-800">{{ $item['cosplayer']->nama_karakter }}</span> &bull; {{ $item['cosplayer']->asal_series }}
                                </td>
                                <td class="py-3 px-4 text-center font-mono font-bold text-blue-700 text-base">
                                    {{ number_format($scoreVal, 4) }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($rank == 1)
                                        <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Terpilih</span>
                                    @else
                                        <span class="text-xs text-slate-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif

</div>
@endsection
