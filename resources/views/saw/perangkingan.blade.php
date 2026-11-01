@extends('layouts.app')

@section('title', 'Hasil Perangkingan')
@section('page_title', 'Hasil Perangkingan')

@section('content')
<div class="space-y-6">

    <!-- Container Form Hasil Perangkingan (Persis Sesuai Gambar 3. 11 Desain Form Hasil Perangkingan) -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">

        <!-- Form Title Header Sesuai Wireframe -->
        <div class="p-6 border-b border-slate-200 text-center bg-slate-50/50">
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Form Hasil Perangkingan
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Perangkingan nilai akhir preferensi ($V_i$) cosplayer dengan metode Simple Additive Weighting (SAW).
            </p>
        </div>

        <!-- Table Sesuai Kerangka: [No | Nama Peserta | Nilai Akhir (Vi) | Peringkat] -->
        <div class="p-6">
            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 text-center w-16 border-r border-slate-200">No</th>
                            <th class="py-3 px-5 border-r border-slate-200">Nama Peserta</th>
                            <th class="py-3 px-5 text-center w-48 border-r border-slate-200">Nilai Akhir (Vi)</th>
                            <th class="py-3 px-5 text-center w-36">Peringkat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($hasilSaw as $index => $item)
                            @php
                                $rank = $item->ranking;
                                $rankBadge = match($rank) {
                                    1 => 'bg-amber-100 text-amber-800 border-amber-300 font-bold',
                                    2 => 'bg-slate-100 text-slate-800 border-slate-300 font-bold',
                                    3 => 'bg-orange-100 text-orange-800 border-orange-300 font-bold',
                                    default => 'bg-slate-50 text-slate-600 border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 text-center text-slate-500 font-mono border-r border-slate-200">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 px-5 border-r border-slate-200">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-xs font-mono font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                            {{ $item->cosplayer->no_peserta }}
                                        </span>
                                        <div>
                                            <span class="font-semibold text-slate-900 block">{{ $item->cosplayer->nama_peserta }}</span>
                                            <span class="text-xs text-slate-500">
                                                {{ $item->cosplayer->nama_karakter }} &bull; {{ $item->cosplayer->asal_series }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-center font-mono font-bold text-blue-700 text-base border-r border-slate-200">
                                    {{ number_format($item->total_nilai, 4) }}
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs border {{ $rankBadge }}">
                                        @if($rank == 1)
                                            <i class="fa-solid fa-trophy text-amber-600 mr-1 text-xs"></i> Juara 1
                                        @elseif($rank == 2)
                                            <i class="fa-solid fa-medal text-slate-500 mr-1 text-xs"></i> Juara 2
                                        @elseif($rank == 3)
                                            <i class="fa-solid fa-award text-orange-600 mr-1 text-xs"></i> Juara 3
                                        @else
                                            Peringkat {{ $rank }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Belum ada data hasil perangkingan. Silakan lakukan proses perhitungan SAW terlebih dahulu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tombol Cetak Laporan (Sesuai Posisi pada Kerangka Gambar 3. 11) -->
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Total Peserta Terkalkulasi: <strong class="text-slate-800">{{ count($hasilSaw) }}</strong>
                </span>
                <a href="{{ route('saw.laporan') }}"
                    class="py-2.5 px-5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold rounded-lg text-sm shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Laporan</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

