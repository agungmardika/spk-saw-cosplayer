@extends('layouts.app')

@section('title', 'Edit Kriteria Penilaian')
@section('page_title', 'Data Kriteria')

@section('content')
<div class="max-w-xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('kriteria.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Kriteria</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-xs p-6 md:p-8">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded bg-blue-50 border border-blue-200 text-blue-700 font-mono font-bold text-xs">
                    {{ $kriteria->kode_kriteria }}
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Ubah Kriteria: {{ $kriteria->nama_kriteria }}
                    </h2>
                    <p class="text-xs text-slate-500">Atur nama kriteria, nilai bobot preferensi ($W$), dan sifat atribut.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('kriteria.update', $kriteria->id_kriteria) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Kode Kriteria (Readonly) -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Kode Kriteria
                </label>
                <input type="text" value="{{ $kriteria->kode_kriteria }}" disabled
                    class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-sm font-mono font-semibold text-slate-500 cursor-not-allowed">
            </div>

            <!-- Nama Kriteria -->
            <div>
                <label for="nama_kriteria" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Kriteria <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                @error('nama_kriteria')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bobot (W) -->
            <div>
                <label for="bobot" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nilai Bobot Preferensi (W) <span class="text-rose-600">*</span>
                </label>
                <input type="number" step="0.01" min="0.01" max="1.0" id="bobot" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-mono font-bold text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                <p class="text-xs text-slate-500 mt-1">Nilai desimal antara 0.01 s.d. 1.00 (contoh: 0.30 untuk 30%).</p>
                @error('bobot')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kriteria -->
            <div>
                <label for="jenis" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Sifat / Tipe Kriteria <span class="text-rose-600">*</span>
                </label>
                <select id="jenis" name="jenis" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                    <option value="benefit" {{ old('jenis', $kriteria->jenis) === 'benefit' ? 'selected' : '' }}>
                        Benefit (Semakin besar nilai semakin baik)
                    </option>
                    <option value="cost" {{ old('jenis', $kriteria->jenis) === 'cost' ? 'selected' : '' }}>
                        Cost (Semakin kecil nilai semakin baik)
                    </option>
                </select>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('kriteria.index') }}" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
