@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page_title', 'Input Penilaian')

@section('content')
<div class="space-y-6">

    <!-- FORM INPUT PENILAIAN (Persis Sesuai Gambar Kerangka Input Penilaian) -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs p-6 md:p-8 max-w-3xl">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                <span>Formulir Input Penilaian Juri</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Pilih peserta dan masukkan nilai juri untuk masing-masing kriteria lomba cosplay.
            </p>
        </div>

        <form action="{{ route('penilaian.store') }}" method="POST" id="form-penilaian" class="space-y-5">
            @csrf

            <!-- 1. Nama Peserta (Select Dropdown) -->
            <div>
                <label for="select_cosplayer" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Peserta
                </label>
                <select id="select_cosplayer" name="id_cosplayer" required onchange="handleCosplayerChange(this.value)"
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                    <option value="">-- Pilih Peserta Cosplayer --</option>
                    @foreach($cosplayers as $c)
                        <option value="{{ $c->id_cosplayer }}" data-karakter="{{ $c->nama_karakter }}" data-series="{{ $c->asal_series }}" data-no="{{ $c->no_peserta }}">
                            {{ $c->no_peserta }} - {{ $c->nama_peserta }} ({{ $c->nama_karakter }})
                        </option>
                    @endforeach
                </select>
                <div id="peserta-info" class="hidden mt-2 text-xs text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200">
                    Karakter: <strong id="info-karakter"></strong> &bull; Seri: <span id="info-series"></span>
                </div>
            </div>

            <!-- Dynamic Fields for Criteria (Detail Kostum, Aksi Panggung, Make Up, Penjiwaan Karakter) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                @foreach($kriteria as $k)
                    <div>
                        <label for="kriteria_{{ $k->id_kriteria }}" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            {{ $k->nama_kriteria }}
                            <span class="text-xs font-normal text-slate-500 font-mono">({{ $k->kode_kriteria }} - Bobot {{ $k->bobot * 100 }}%)</span>
                        </label>
                        <div class="relative">
                            <input type="number" min="0" max="100" step="1"
                                id="kriteria_{{ $k->id_kriteria }}"
                                name="nilai[{{ $k->id_kriteria }}]"
                                placeholder="Rentang 0 - 100"
                                required
                                class="score-field w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-mono text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tombol Simpan (Sesuai Kerangka Wireframe) -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Nilai otomatis disimpan dan memperbarui perangkingan SAW.
                </span>
                <button type="submit"
                    class="py-2.5 px-6 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold rounded-lg text-sm shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- TABEL REKAPITULASI PENILAIAN JURI (Lengkap dengan Pencarian & Nilai) -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">
                    Matriks Data Penilaian Seluruh Peserta
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Data penilaian juri untuk 4 kriteria lomba cosplay.
                </p>
            </div>

            <!-- Search Field -->
            <form action="{{ route('penilaian.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..."
                    class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 w-52 sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                @if(request('search'))
                    <a href="{{ route('penilaian.index') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                        <th class="py-3 px-4 text-center w-14">No</th>
                        <th class="py-3 px-4 w-24">No. Peserta</th>
                        <th class="py-3 px-4">Nama Peserta</th>
                        <th class="py-3 px-4">Karakter & Seri</th>
                        @foreach($kriteria as $k)
                            <th class="py-3 px-4 text-center">
                                <div>{{ $k->nama_kriteria }}</div>
                                <div class="text-[10px] text-slate-500 font-normal font-mono">({{ $k->kode_kriteria }})</div>
                            </th>
                        @endforeach
                        <th class="py-3 px-4 text-center bg-slate-100/60 font-bold">Total Nilai</th>
                        <th class="py-3 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($cosplayers as $index => $coser)
                        @php
                            $rowTotal = 0;
                            foreach($kriteria as $k) {
                                $rowTotal += ($penilaianMap[$coser->id_cosplayer][$k->id_kriteria] ?? 0);
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-center text-slate-500 font-mono">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-blue-700">
                                <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200">
                                    {{ $coser->no_peserta }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                {{ $coser->nama_peserta }}
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                <span class="font-medium text-slate-800">{{ $coser->nama_karakter }}</span>
                                <span class="text-xs text-slate-500 block">{{ $coser->asal_series }}</span>
                            </td>

                            @foreach($kriteria as $k)
                                @php
                                    $score = $penilaianMap[$coser->id_cosplayer][$k->id_kriteria] ?? 0;
                                @endphp
                                <td class="py-3 px-4 text-center font-mono font-semibold {{ $score > 0 ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ $score }}
                                </td>
                            @endforeach

                            <td class="py-3 px-4 text-center bg-slate-50/80 font-mono font-bold text-blue-700">
                                {{ $rowTotal }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('penilaian.edit', $coser->id_cosplayer) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-200 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium text-xs transition-colors">
                                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + count($kriteria) }}" class="py-8 text-center text-slate-500">
                                Tidak ada data peserta yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Data map in JS for auto-fill on select -->
<script>
    const penilaianData = @json($penilaianMap);

    function handleCosplayerChange(cosplayerId) {
        const select = document.getElementById('select_cosplayer');
        const selectedOption = select.options[select.selectedIndex];
        const infoBox = document.getElementById('peserta-info');

        if (!cosplayerId) {
            infoBox.classList.add('hidden');
            document.querySelectorAll('.score-field').forEach(input => input.value = '');
            return;
        }

        // Show character info
        document.getElementById('info-karakter').textContent = selectedOption.getAttribute('data-karakter');
        document.getElementById('info-series').textContent = selectedOption.getAttribute('data-series');
        infoBox.classList.remove('hidden');

        // Populate criteria scores if already existing
        const userScores = penilaianData[cosplayerId] || {};
        @foreach($kriteria as $k)
            const input_{{ $k->id_kriteria }} = document.getElementById('kriteria_{{ $k->id_kriteria }}');
            if (input_{{ $k->id_kriteria }}) {
                input_{{ $k->id_kriteria }}.value = userScores[{{ $k->id_kriteria }}] !== undefined ? userScores[{{ $k->id_kriteria }}] : '';
            }
        @endforeach
    }
</script>
@endsection
