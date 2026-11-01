@extends('layouts.app')

@section('title', 'Beranda')
@section('page_title', 'Beranda')

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Summary Cards (Flat, Clean Modern Blue & Slate) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Peserta -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Peserta</span>
                    <h3 class="text-2xl font-bold font-mono text-slate-900 mt-1">{{ $totalCosplayer }}</h3>
                    <p class="text-xs text-blue-600 font-medium mt-1">Cosplayer Terdaftar</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Total Kriteria -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Data Kriteria</span>
                    <h3 class="text-2xl font-bold font-mono text-slate-900 mt-1">{{ $totalKriteria }}</h3>
                    <p class="text-xs text-blue-600 font-medium mt-1">Total Bobot: 1.00 (100%)</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-sliders"></i>
                </div>
            </div>
        </div>

        <!-- Total Penilaian -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Data Penilaian</span>
                    <h3 class="text-2xl font-bold font-mono text-slate-900 mt-1">{{ $totalPenilaian }}</h3>
                    <p class="text-xs text-blue-600 font-medium mt-1">Nilai Terinput</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
            </div>
        </div>

        <!-- Status Metode SAW -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Metode SAW</span>
                    <h3 class="text-lg font-bold text-emerald-600 mt-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                        <span>Terkalkulasi</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Benefit Normalization</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calculator"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN SECTION: TABLE PERANGKINGAN (Sesuai Gambar Kerangka Beranda) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Table Card (2 Kolom pada Layar Lebar) -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden flex flex-col justify-between">
            <div>
                <!-- Table Card Header -->
                <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">
                            Ringkasan Nilai Akhir & Perangkingan
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Hasil perhitungan preferensi ($V_i$) metode Simple Additive Weighting.
                        </p>
                    </div>
                    <a href="{{ route('saw.ranking') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700">
                        <span>Lihat Semua</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Table Sesuai Kerangka: [Nama Peserta | Nilai Akhir (Vi) | Peringkat] -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                                <th class="py-3 px-5">Nama Peserta</th>
                                <th class="py-3 px-5 text-center w-40">Nilai Akhir (Vi)</th>
                                <th class="py-3 px-5 text-center w-32">Peringkat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($topRanking as $item)
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
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-2.5">
                                            <span class="text-xs font-mono font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                                {{ $item->cosplayer->no_peserta }}
                                            </span>
                                            <div>
                                                <span class="font-semibold text-slate-900 block">{{ $item->cosplayer->nama_peserta }}</span>
                                                <span class="text-xs text-slate-500">
                                                    {{ $item->cosplayer->nama_karakter }} ({{ $item->cosplayer->asal_series }})
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-5 text-center font-mono font-bold text-blue-700 text-base">
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
                                    <td colspan="3" class="py-8 text-center text-slate-500 text-sm">
                                        Belum ada data perangkingan. Silakan lakukan penilaian juri lalu proses perhitungan SAW.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Card Footer -->
            <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                <span>Formula SAW: Preferensi $V_i = \sum (w_j \times r_{ij})$</span>
                <div class="flex items-center gap-3">
                    <a href="{{ route('saw.index') }}" class="font-semibold text-blue-600 hover:underline">Perhitungan Matriks Lengkap &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Sidebar Kolom Kanan: Bobot Kriteria & Aksi Cepat -->
        <div class="space-y-6">

            <!-- Bobot Kriteria Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-scale-balanced text-blue-600"></i>
                        <span>Bobot Kriteria Penilaian</span>
                    </h3>
                    <a href="{{ route('kriteria.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">Kelola</a>
                </div>

                <div class="space-y-3">
                    @foreach($kriteriaList as $k)
                        @php
                            $pct = $k->bobot * 100;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1">
                                <span class="font-semibold text-slate-800">
                                    <span class="font-mono text-blue-600 font-bold mr-1">{{ $k->kode_kriteria }}</span>
                                    {{ $k->nama_kriteria }}
                                </span>
                                <span class="font-mono font-bold text-slate-700">{{ $pct }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Aksi Cepat Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 pb-3 border-b border-slate-200">
                    Aksi Pintas Sistem
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('penilaian.index') }}"
                        class="w-full flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition-colors text-xs font-semibold text-slate-700 hover:text-blue-700">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                            Input Nilai Juri
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    </a>
                    <a href="{{ route('saw.index') }}"
                        class="w-full flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition-colors text-xs font-semibold text-slate-700 hover:text-blue-700">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-calculator text-blue-600"></i>
                            Proses Hitung SAW
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    </a>
                    <a href="{{ route('saw.laporan') }}"
                        class="w-full flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition-colors text-xs font-semibold text-slate-700 hover:text-blue-700">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-print text-blue-600"></i>
                            Cetak Laporan & Berita Acara
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
