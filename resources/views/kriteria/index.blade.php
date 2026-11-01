@extends('layouts.app')

@section('title', 'Data Kriteria')
@section('page_title', 'Data Kriteria')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-sliders text-blue-600"></i>
                <span>Data Kriteria & Pembobotan SAW</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Atribut dasar yang digunakan untuk mengevaluasi cosplayer.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="confirmResetKriteria()"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left text-slate-500"></i>
                <span>Reset ke Standar Default</span>
            </button>
            <form id="reset-kriteria-form" action="{{ route('kriteria.reset') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Weight Validation Alert Banner -->
    @php
        $isBalanced = abs($totalBobot - 1.00) < 0.001;
    @endphp
    <div class="p-4 rounded-xl border {{ $isBalanced ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800' }} flex items-center justify-between">
        <div class="flex items-center gap-2.5 text-xs">
            <i class="fa-solid {{ $isBalanced ? 'fa-circle-check text-emerald-600' : 'fa-circle-exclamation text-rose-600' }} text-base"></i>
            <div>
                <strong>Status Akumulasi Bobot ($W$):</strong>
                {{ $isBalanced ? 'Ideal (Tepat bernilai 1.00 / 100%)' : 'Peringatan: Total bobot saat ini ' . $totalBobot . ' (Harus bernilai 1.00)!' }}
            </div>
        </div>
        <div class="text-xs font-mono font-bold px-3 py-1 rounded {{ $isBalanced ? 'bg-emerald-100 text-emerald-900' : 'bg-rose-100 text-rose-900' }}">
            Total: {{ number_format($totalBobot, 2) }}
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                        <th class="py-3 px-4 text-center w-20">Kode</th>
                        <th class="py-3 px-4">Nama Kriteria</th>
                        <th class="py-3 px-4 text-center w-32">Nilai Bobot (W)</th>
                        <th class="py-3 px-4 text-center w-28">Persentase</th>
                        <th class="py-3 px-4 text-center w-32">Sifat Kriteria</th>
                        <th class="py-3 px-4">Deskripsi Aspek Penilaian</th>
                        <th class="py-3 px-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($kriteria as $k)
                        @php
                            $deskripsi = match($k->kode_kriteria) {
                                'C1' => 'Kerapian jahitan, akurasi pola pakaian, material aksesoris, dan prop senjata.',
                                'C2' => 'Penguasaan panggung, koreografi, gestur khas anime, dan interaksi penonton.',
                                'C3' => 'Teknik make-up karakter, kerapian styling wig / wig styling, dan kontur wajah.',
                                'C4' => 'Akting penjiwaan peran, ekspresi wajah, kesesuaian aura tokoh (in-character).',
                                default => 'Aspek penilaian lomba cosplay.'
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-mono font-bold">
                                <span class="px-2.5 py-1 rounded bg-blue-50 border border-blue-200 text-blue-700 text-xs">
                                    {{ $k->kode_kriteria }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $k->nama_kriteria }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-blue-700">
                                {{ number_format($k->bobot, 2) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-mono text-xs font-semibold">
                                    {{ $k->bobot * 100 }}%
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 capitalize">
                                    {{ $k->jenis }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-xs leading-relaxed">
                                {{ $deskripsi }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="{{ route('kriteria.edit', $k->id_kriteria) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors">
                                    <i class="fa-solid fa-pen-to-square text-[11px] text-blue-600"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function confirmResetKriteria() {
        Swal.fire({
            title: 'Reset Kriteria ke Standar Default?',
            html: 'Kriteria akan dikembalikan ke 4 kriteria standar default:<br><ul class="text-xs text-left list-disc list-inside mt-2 text-slate-600"><li><b>C1: Detail Kostum (0.30)</b></li><li><b>C2: Aksi Panggung (0.25)</b></li><li><b>C3: Make Up/Rias Wajah (0.20)</b></li><li><b>C4: Penjiwaan Karakter (0.25)</b></li></ul>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Kembalikan Standar',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reset-kriteria-form').submit();
            }
        });
    }
</script>
@endpush
@endsection
