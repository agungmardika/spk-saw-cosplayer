@extends('layouts.app')

@section('title', 'Profil Pengguna')
@section('page_title', 'Profil Pengguna')

@section('content')
<div class="max-w-2xl space-y-6">

    <!-- Profile Header Card (Sesuai Konsep Lingkaran Profil pada Kerangka) -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-xs flex items-center gap-4">
        <div class="h-16 w-16 rounded-full border-2 border-blue-600 bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-xl uppercase tracking-tight shrink-0 shadow-xs">
            Profil
        </div>
        <div>
            <h2 class="text-lg font-bold text-slate-900">{{ $user->nama_lengkap }}</h2>
            <p class="text-xs text-blue-600 font-mono">@<span>{{ $user->username }}</span> &bull; Administrator Sistem</p>
            <p class="text-xs text-slate-500 mt-1">Sistem Penunjang Keputusan Penilaian Cosplayer Metode SAW.</p>
        </div>
    </div>

    <!-- Update Form -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs p-6 md:p-8">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-shield text-blue-600"></i>
                <span>Pengaturan Akun & Kata Sandi</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui nama pengguna atau ganti kata sandi login admin.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                @error('nama_lengkap')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Username Login <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all">
                @error('username')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ganti Password Section -->
            <div class="pt-4 border-t border-slate-200">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-key text-blue-600"></i>
                    <span>Ganti Kata Sandi (Opsional)</span>
                </h4>
                <p class="text-xs text-slate-500 mb-4">Kosongkan jika Anda tidak ingin mengubah kata sandi.</p>

                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kata Sandi Saat Ini
                        </label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                            placeholder="Masukkan sandi lama jika ingin mengganti">
                        @error('current_password')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Kata Sandi Baru
                            </label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                                placeholder="Minimal 6 karakter">
                            @error('new_password')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Konfirmasi Sandi Baru
                            </label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                                placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Pengaturan Profil</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
