<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPPB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-image: url("{{ asset('img/algazel_bg.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* 50% opacity hitam */
            z-index: 1;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12">

    <div class="w-full max-w-md">
        <!-- Back button moved outside header -->
        <div class="mb-4">
            <button type="button" onclick="history.back()" class="inline-flex items-center px-3 py-2 bg-white/20 text-gray-700 rounded-md hover:bg-white/30 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
        </div>

        <div class="rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header / Brand -->
            <div class="flex items-center justify-center gap-4 p-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <img src="{{ asset('img/kv.png') }}" alt="Logo" class="h-12 w-auto object-contain">
                <div class="text-white">
                    <h2 class="text-2xl font-bold">SPPB</h2>
                    <p class="text-sm opacity-90">Sistem Peminjaman & Pemulangan Buku</p>
                </div>
            </div>

            <!-- Card Body -->
            <div class="bg-white p-8">
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-800">
                        <strong class="block font-semibold">Login Gagal!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" value="{{ old('username') }}" required autofocus
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            type="text" />
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            type="password" />
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                            class="w-full rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 font-semibold transition">
                            Login
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer note -->
            <div class="bg-gray-50 text-center p-4 text-xs text-gray-500">
                © {{ date('Y') }} SPPB — Semua hak cipta terpelihara
            </div>
        </div>
    </div>

</body>
</html>