<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Cosplayer Metode SAW</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-slate-100 text-slate-800">

    <!-- Main Dual Panel Container (Sesuai Gambar Kerangka Login) -->
    <div class="w-full max-w-4xl bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- PANEL KIRI: FORM LOGIN -->
        <div class="p-8 sm:p-10 lg:p-12 flex flex-col justify-between">
            <div>
                <!-- Title -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight text-center md:text-left">
                        Login
                    </h1>
                    <p class="text-xs text-slate-500 mt-1.5 text-center md:text-left">
                        Silakan masukkan kredensial akun administrator Anda.
                    </p>
                </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Username :
                        </label>
                        <div class="relative">
                            <input type="text" id="username" name="username" value="{{ old('username', 'admin') }}" required autofocus
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all"
                                placeholder="Username">
                        </div>
                        @error('username')
                            <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password :
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required value="admin123"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-all pr-10"
                                placeholder="Password">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i id="password-toggle-icon" class="fa-solid fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Option -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>Ingat login saya</span>
                        </label>
                        <span class="text-slate-400 font-mono text-[11px]">v1.0 &bull; 2026</span>
                    </div>

                    <!-- Submit Login Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold rounded-lg text-sm shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                            <span>Login</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Akun default info (clean subtle box) -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Default: <strong class="text-slate-700 font-mono">admin</strong> / <strong class="text-slate-700 font-mono">admin123</strong></span>
                <span class="text-blue-600 font-medium">Bina Satria</span>
            </div>
        </div>

        <!-- PANEL KANAN: SPK COSPLAYER METODE SAW (Modern Blue Panel) -->
        <div class="bg-blue-700 text-white p-8 sm:p-10 lg:p-12 flex flex-col justify-between relative overflow-hidden border-t md:border-t-0 md:border-l border-blue-600">
            <!-- Subtle geometric accent line -->
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full border border-blue-500/30 pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full border border-blue-500/30 pointer-events-none"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-800/80 border border-blue-500/40 text-blue-200 text-xs font-semibold uppercase tracking-wider mb-8">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                    <span>Sistem Pendukung Keputusan</span>
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                    SPK Cosplayer
                </h2>
                <h3 class="text-xl sm:text-2xl font-bold text-blue-200 mt-2">
                    Metode SAW
                </h3>
            </div>

            <!-- Description Text Sesuai Wireframe -->
            <div class="relative z-10 my-8">
                <p class="text-sm text-blue-100/90 leading-relaxed max-w-sm">
                    Sistem Penunjang Keputusan Penilaian Cosplayer hanya dapat diakses oleh admin, silakan login terlebih dahulu.
                </p>

                <div class="mt-6 pt-6 border-t border-blue-600/60 grid grid-cols-2 gap-4 text-xs text-blue-200">
                    <div>
                        <span class="block text-blue-300 font-semibold uppercase text-[10px] tracking-wider">Komunitas</span>
                        <p class="font-medium text-white mt-0.5">Kalsel Unite</p>
                    </div>
                    <div>
                        <span class="block text-blue-300 font-semibold uppercase text-[10px] tracking-wider">Lokasi</span>
                        <p class="font-medium text-white mt-0.5">Banjarbaru</p>
                    </div>
                </div>
            </div>

            <!-- Footer note -->
            <div class="relative z-10 text-xs text-blue-200/80">
                <span>Sistem Pendukung Keputusan &bull; 2026</span>
            </div>
        </div>

    </div>

    <!-- Script toggle password -->
    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('password-toggle-icon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
