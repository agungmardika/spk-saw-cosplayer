@extends('layouts.app')

@section('title', 'Tambah Data Peserta')
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
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-blue-600"></i>
                <span>Tambah Data Peserta Cosplayer</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Lengkapi data alternatif peserta kompetisi cosplay Kalsel Unite.
            </p>
        </div>

        <form action="{{ route('cosplayer.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- No Peserta -->
            <div>
                <label for="no_peserta" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nomor Peserta <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="no_peserta" name="no_peserta" value="{{ old('no_peserta', $autoNo) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-mono font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                    placeholder="Contoh: P01, P21">
                <p class="text-xs text-slate-500 mt-1">Format kode alternatif (misal: P01 s.d. P20).</p>
                @error('no_peserta')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap Peserta -->
            <div>
                <label for="nama_peserta" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap Peserta <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="nama_peserta" name="nama_peserta" value="{{ old('nama_peserta') }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                    placeholder="Masukkan nama asli atau panggung peserta">
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
                    <input type="text" id="nama_karakter" name="nama_karakter" value="{{ old('nama_karakter') }}" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                        placeholder="Contoh: Gojo Satoru, Tanjiro">
                    @error('nama_karakter')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Asal Anime/Series -->
                <div>
                    <label for="asal_series" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Asal Anime / Game / Seri <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="asal_series" name="asal_series" value="{{ old('asal_series') }}" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                        placeholder="Contoh: Jujutsu Kaisen, Genshin Impact">
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
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                    placeholder="Contoh: Menggunakan properti pedang lampu, kostum buatan sendiri...">{{ old('catatan') }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('cosplayer.index') }}" class="px-4 py-2.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data Peserta</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
