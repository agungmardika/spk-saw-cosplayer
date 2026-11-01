@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page_title', 'Input Penilaian')

@section('content')
<div class="max-w-2xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('penilaian.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Input Penilaian</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-xs p-6 md:p-8">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <div>
                    <span class="px-2.5 py-0.5 rounded bg-blue-50 border border-blue-200 text-blue-700 font-mono font-semibold text-xs">
                        {{ $cosplayer->no_peserta }}
                    </span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">
                        Penilaian: {{ $cosplayer->nama_peserta }}
                    </h2>
                    <p class="text-xs text-slate-500">
                        Karakter: <strong class="text-slate-800">{{ $cosplayer->nama_karakter }}</strong> ({{ $cosplayer->asal_series }})
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block">Total Skor</span>
                    <span id="live-total" class="text-2xl font-bold font-mono text-blue-700">0</span>
                </div>
            </div>
        </div>

        <form action="{{ route('penilaian.update', $cosplayer->id_cosplayer) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                @foreach($kriteria as $k)
                    @php
                        $val = old("nilai.{$k->id_kriteria}", $existingNilai[$k->id_kriteria] ?? 0);
                    @endphp
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <div class="flex items-center justify-between mb-2">
                            <label for="kriteria_{{ $k->id_kriteria }}" class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded font-mono font-bold text-xs bg-blue-100 text-blue-800">
                                    {{ $k->kode_kriteria }}
                                </span>
                                <span>{{ $k->nama_kriteria }}</span>
                            </label>
                            <span class="text-xs text-slate-500">Bobot: {{ $k->bobot * 100 }}%</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="number" step="1" min="0" max="100"
                                id="kriteria_{{ $k->id_kriteria }}"
                                name="nilai[{{ $k->id_kriteria }}]"
                                value="{{ $val }}"
                                required
                                oninput="calcLiveTotal()"
                                class="score-input w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all">
                            <span class="text-xs text-slate-500 font-mono">/ 0-100</span>
                        </div>
                        @error("nilai.{$k->id_kriteria}")
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('penilaian.index') }}" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function calcLiveTotal() {
        const inputs = document.querySelectorAll('.score-input');
        let total = 0;
        inputs.forEach(i => {
            total += parseFloat(i.value) || 0;
        });
        document.getElementById('live-total').textContent = total;
    }
    document.addEventListener('DOMContentLoaded', calcLiveTotal);
</script>
@endpush
