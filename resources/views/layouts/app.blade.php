<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK Cosplayer') - Metode SAW</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Clean SweetAlert Theme */
        .swal2-popup {
            background: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        }
        .swal2-title {
            color: #0f172a !important;
            font-size: 1.15rem !important;
        }
        .swal2-html-container {
            color: #475569 !important;
            font-size: 0.875rem !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full flex overflow-hidden bg-slate-50 text-slate-800 antialiased">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-xs hidden md:hidden"></div>

    <!-- SIDEBAR (Sesuai Kerangka Wireframe) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-200 ease-in-out flex flex-col bg-white border-r border-slate-200 shadow-xs">

        <!-- Top Profile & System Brand Header (Sesuai Lingkaran 'Profil' pada Kerangka) -->
        <div class="p-4 border-b border-slate-200 bg-slate-50/50">
            <div class="flex items-center justify-between">
                <a href="{{ route('profile') }}" class="group flex items-center gap-2.5 p-1.5 -ml-1.5 rounded-xl hover:bg-white hover:shadow-xs border border-transparent hover:border-slate-200 transition-all" title="Buka Pengaturan Profil">
                    <!-- Circular Profil Badge sesuai gambar kerangka -->
                    <div class="h-10 w-10 rounded-full border-2 border-blue-600 bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-xs uppercase tracking-tight shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                        Profil
                    </div>
                    <div class="truncate">
                        <span class="block text-xs font-bold text-slate-900 truncate">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
                        <span class="block text-[11px] text-slate-500 font-mono">@<span>{{ Auth::user()->username ?? 'admin' }}</span></span>
                    </div>
                </a>
                <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Menu (8 Menu Persis Sesuai Gambar Kerangka) -->
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">

            <!-- 1. Beranda -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-house w-4 text-center {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Beranda</span>
            </a>

            <!-- 2. Data Peserta -->
            <a href="{{ route('cosplayer.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cosplayer.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-users w-4 text-center {{ request()->routeIs('cosplayer.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Data Peserta</span>
            </a>

            <!-- 3. Data Kriteria -->
            <a href="{{ route('kriteria.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('kriteria.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-sliders w-4 text-center {{ request()->routeIs('kriteria.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Data Kriteria</span>
            </a>

            <!-- 4. Input Penilaian -->
            <a href="{{ route('penilaian.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('penilaian.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-pen-to-square w-4 text-center {{ request()->routeIs('penilaian.*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Input Penilaian</span>
            </a>

            <!-- 5. Perhitungan SAW -->
            <a href="{{ route('saw.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('saw.index') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-calculator w-4 text-center {{ request()->routeIs('saw.index') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Perhitungan SAW</span>
            </a>

            <!-- 6. Hasil Perangkingan -->
            <a href="{{ route('saw.ranking') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('saw.ranking') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-ranking-star w-4 text-center {{ request()->routeIs('saw.ranking') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Hasil Perangkingan</span>
            </a>

            <!-- 7. Laporan -->
            <a href="{{ route('saw.laporan') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('saw.laporan') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-file-lines w-4 text-center {{ request()->routeIs('saw.laporan') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Laporan</span>
            </a>

            <div class="pt-3 my-2 border-t border-slate-200"></div>

            <!-- 8. Keluar -->
            <button onclick="confirmLogout()" type="button"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors text-left">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                <span>Keluar</span>
            </button>
        </nav>

        <!-- System Branding at bottom -->
        <div class="p-3.5 border-t border-slate-200 bg-slate-50 text-[11px] text-slate-500 text-center">
            <span class="font-semibold text-slate-700">SPK Cosplayer</span> &bull; Metode SAW
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- TOP BAR -->
        <header class="h-15 border-b border-slate-200 bg-white flex items-center justify-between px-4 sm:px-6 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-tight">
                        @yield('page_title', 'SPK Penilaian Cosplayer')
                    </h2>
                    <p class="text-[11px] text-slate-500 hidden sm:block">
                        Metode Simple Additive Weighting &bull; Komunitas Kalsel Unite
                    </p>
                </div>
            </div>

            <!-- Header Right: Quick Profil & Actions -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('profile') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200 transition-colors">
                    <i class="fa-solid fa-circle-user text-blue-600 text-sm"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('saw.laporan') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white shadow-xs transition-colors">
                    <i class="fa-solid fa-print"></i>
                    <span class="hidden sm:inline">Cetak Laporan</span>
                </a>
            </div>
        </header>

        <!-- PAGE CONTENT CONTAINER -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 bg-slate-50">
            @yield('content')
        </main>
    </div>

    <!-- SweetAlert2 Scripts & Flash Notifications -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin keluar dari sistem SPK Cosplayer?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-right-from-bracket mr-1"></i> Ya, Keluar',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function confirmDelete(formId, itemName) {
            Swal.fire({
                title: 'Hapus Data?',
                html: `Apakah Anda yakin ingin menghapus <b>${itemName}</b>?<br><span class="text-xs text-rose-600">Tindakan ini tidak dapat dibatalkan!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Global Flash Message handler
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('swal_success') }}",
                    confirmButtonColor: '#2563eb',
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            @if(session('swal_error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: "{{ session('swal_error') }}",
                    confirmButtonColor: '#dc2626',
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
