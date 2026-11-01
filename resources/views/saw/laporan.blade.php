<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Penilaian & Perangkingan Cosplayer - Metode SAW</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background-color: #f8fafc;
        }
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
            }
            .no-print {
                display: none !important;
            }
            .print-border {
                border-color: #000000 !important;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="p-4 md:p-8">

    <!-- Action Bar (Hidden when printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white border border-slate-200 text-slate-800 p-4 rounded-xl shadow-xs">
        <a href="{{ route('saw.ranking') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Form Perangkingan</span>
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-xs flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-print"></i>
                <span>Cetak / Cetak PDF (A4)</span>
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-xl border border-slate-200 text-slate-900 print:shadow-none print:border-none print:p-0">

        <!-- KOP SURAT / HEADER -->
        <div class="text-center border-b-2 border-slate-900 pb-5 mb-6">
            <h1 class="text-xl md:text-2xl font-bold uppercase tracking-wider text-slate-900">
                PANITIA LOMBA COSPLAY KALSEL UNITE
            </h1>
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-700 mt-1">
                Sistem Penunjang Keputusan Penilaian Cosplayer Metode Simple Additive Weighting (SAW)
            </h2>
            <p class="text-xs text-slate-600 mt-1">
                Lokasi Pelaksanaan: Gedung Bina Satria Banjarbaru (2026)
            </p>
        </div>

        <!-- Berita Acara Info -->
        <div class="text-center mb-6">
            <h3 class="text-base font-bold underline uppercase tracking-wide">
                BERITA ACARA & LAPORAN HASIL KEPUTUSAN JUARA
            </h3>
            <p class="text-xs text-slate-600 mt-1">
                Nomor: BA-COSPLAY/KU/{{ date('Y') }}/{{ date('m') }} &bull; Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
        </div>

        <p class="text-xs text-slate-700 leading-relaxed mb-4 text-justify">
            Berdasarkan hasil penilaian juri dan pengolahan data menggunakan metode <strong>Simple Additive Weighting (SAW)</strong> dengan 4 kriteria terbobot (Detail Kostum [30%], Aksi Panggung [25%], Make Up/Rias Wajah [20%], dan Penjiwaan Karakter [25%]), maka diputuskan hasil perangkingan cosplayer sebagai berikut:
        </p>

        <!-- TABLE OF RESULTS -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse border border-slate-400 text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-900 font-bold border-b border-slate-400">
                        <th class="border border-slate-400 py-2.5 px-3 text-center w-14">Rank</th>
                        <th class="border border-slate-400 py-2.5 px-3 text-center w-20">No. Peserta</th>
                        <th class="border border-slate-400 py-2.5 px-3">Nama Lengkap Cosplayer</th>
                        <th class="border border-slate-400 py-2.5 px-3">Karakter / Series</th>
                        <th class="border border-slate-400 py-2.5 px-3 text-center w-28">Nilai Preferensi (V)</th>
                        <th class="border border-slate-400 py-2.5 px-3 text-center w-28">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300">
                    @foreach($hasilSaw as $res)
                        @php
                            $rank = $res->ranking;
                            $keterangan = match($rank) {
                                1 => 'JUARA I',
                                2 => 'JUARA II',
                                3 => 'JUARA III',
                                default => 'Peserta Finalis'
                            };
                            $rowBg = match($rank) {
                                1 => 'bg-amber-50 font-semibold',
                                2 => 'bg-slate-50 font-semibold',
                                3 => 'bg-amber-50/50 font-semibold',
                                default => ''
                            };
                        @endphp
                        <tr class="{{ $rowBg }}">
                            <td class="border border-slate-400 py-2 px-3 text-center font-bold">
                                {{ $rank }}
                            </td>
                            <td class="border border-slate-400 py-2 px-3 text-center font-mono font-bold">
                                {{ $res->cosplayer->no_peserta }}
                            </td>
                            <td class="border border-slate-400 py-2 px-3">
                                {{ $res->cosplayer->nama_peserta }}
                            </td>
                            <td class="border border-slate-400 py-2 px-3 text-slate-700">
                                <strong>{{ $res->cosplayer->nama_karakter }}</strong> ({{ $res->cosplayer->asal_series }})
                            </td>
                            <td class="border border-slate-400 py-2 px-3 text-center font-mono font-bold text-slate-900">
                                {{ number_format($res->total_nilai, 4) }}
                            </td>
                            <td class="border border-slate-400 py-2 px-3 text-center font-bold text-slate-800">
                                {{ $keterangan }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Penjelasan Kriteria & Bobot -->
        <div class="mb-8 p-3 rounded-lg border border-slate-300 bg-slate-50 text-[11px] text-slate-700">
            <strong>Parameter Bobot Metode SAW:</strong>
            C1 Detail Kostum = 0.30 &bull; C2 Aksi Panggung = 0.25 &bull; C3 Make Up/Rias Wajah = 0.20 &bull; C4 Penjiwaan Karakter = 0.25 (Total: 1.00)
        </div>

        <!-- SIGNATURES BLOCK -->
        <div class="grid grid-cols-3 gap-6 text-xs text-center pt-4">
            <div>
                <p class="text-slate-600">Mengetahui,</p>
                <p class="font-semibold text-slate-800">Ketua Panitia Lomba</p>
                <div class="h-20"></div>
                <p class="font-bold underline text-slate-900">Muhammad Fahmi</p>
                <p class="text-[10px] text-slate-500">Panitia Kalsel Unite</p>
            </div>

            <div>
                <p class="text-slate-600">Disahkan oleh,</p>
                <p class="font-semibold text-slate-800">Dewan Juri Cosplay</p>
                <div class="h-20"></div>
                <p class="font-bold underline text-slate-900">(...........................................)</p>
                <p class="text-[10px] text-slate-500">Juri Perlombaan</p>
            </div>

            <div>
                <p class="text-slate-600">Banjarbaru, {{ date('d F Y') }}</p>
                <p class="font-semibold text-slate-800">Peneliti / Administrator</p>
                <div class="h-20"></div>
                <p class="font-bold underline text-slate-900">Septian Rahmat Hidayat</p>
                <p class="text-[10px] text-slate-500">NIM: 310120023567</p>
            </div>
        </div>

    </div>

</body>
</html>
