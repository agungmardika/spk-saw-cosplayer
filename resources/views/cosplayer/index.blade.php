@extends('layouts.app')

@section('title', 'Data Peserta')
@section('page_title', 'Data Peserta')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Search -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-users text-blue-600"></i>
                <span>Daftar Peserta Cosplayer</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Kelola data alternatif peserta lomba cosplay.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('cosplayer.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / karakter..."
                    class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 w-48 sm:w-60">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                @if(request('search'))
                    <a href="{{ route('cosplayer.index') }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>

            <!-- Add Button -->
            <a href="{{ route('cosplayer.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Peserta</span>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                        <th class="py-3 px-4 text-center w-16">No</th>
                        <th class="py-3 px-4 w-28">No. Peserta</th>
                        <th class="py-3 px-4">Nama Lengkap Peserta</th>
                        <th class="py-3 px-4">Karakter yang Diperankan</th>
                        <th class="py-3 px-4">Asal Anime / Series</th>
                        <th class="py-3 px-4 text-center">Peringkat SAW</th>
                        <th class="py-3 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($cosplayers as $index => $coser)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-center text-slate-500 font-mono">
                                {{ $cosplayers->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-blue-700">
                                <span class="px-2 py-0.5 rounded bg-blue-50 border border-blue-200">
                                    {{ $coser->no_peserta }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                {{ $coser->nama_peserta }}
                            </td>
                            <td class="py-3 px-4 font-medium text-slate-800">
                                {{ $coser->nama_karakter }}
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-xs">
                                {{ $coser->asal_series }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($coser->hasilSaw)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $coser->hasilSaw->ranking <= 3 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                        Juara {{ $coser->hasilSaw->ranking }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Belum dinilai</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('cosplayer.edit', $coser->id_cosplayer) }}"
                                        class="p-1.5 rounded text-blue-600 hover:bg-blue-50 transition-colors" title="Edit Peserta">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button"
                                        onclick="confirmDelete('delete-form-{{ $coser->id_cosplayer }}', '{{ $coser->nama_peserta }}')"
                                        class="p-1.5 rounded text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Peserta">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $coser->id_cosplayer }}" action="{{ route('cosplayer.destroy', $coser->id_cosplayer) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Tidak ada data peserta cosplayer yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($cosplayers->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $cosplayers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
