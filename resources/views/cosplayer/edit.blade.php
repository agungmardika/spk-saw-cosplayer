@extends('layouts.app')

@section('title', 'Edit Data Peserta')
@section('page_title', 'Data Peserta')

@section('content')
<div class="max-w-2xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('cosplayer.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Peserta</span>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-xs p-6 md:p-8">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded bg-blue-50 border border-blue-200 text-blue-700 font-mono font-bold text-xs">
                    {{ $cosplayer->no_peserta }}
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Ubah Data: {{ $cosplayer->nama_peserta }}
                    </h2>
                    <p class="text-xs text-slate-500">Perbarui data profil dan karakter peserta cosplay.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('cosplayer.update', $cosplayer->id_cosplayer) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- No Peserta -->
            <div>
                <label for="no_peserta" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nomor Peserta <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="no_peserta" name="no_peserta" value="{{ old('no_peserta', $cosplayer->no_peserta) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-mono font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                @error('no_peserta')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap Peserta -->
            <div>
                <label for="nama_peserta" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap Peserta <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="nama_peserta" name="nama_peserta" value="{{ old('nama_peserta', $cosplayer->nama_peserta) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                @error('nama_peserta')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Karakter yang Diperankan -->
                <div>
                    <label for="nama_karakter" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Karakter yang Diperankan <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="nama_karakter" name="nama_karakter" value="{{ old('nama_karakter', $cosplayer->nama_karakter) }}" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                    @error('nama_karakter')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Asal Anime/Series -->
                <div>
                    <label for="asal_series" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Asal Anime / Game / Seri <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="asal_series" name="asal_series" value="{{ old('asal_series', $cosplayer->asal_series) }}" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                    @error('asal_series')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan Tambahan (Opsional) -->
            <div>
                <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Catatan Khusus Peserta (Opsional)
                </label>
                <textarea id="catatan" name="catatan" rows="3"
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">{{ old('catatan', $cosplayer->catatan) }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('cosplayer.index') }}" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
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
