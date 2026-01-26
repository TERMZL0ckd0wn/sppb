<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPPB</title>
    <!-- Memuat Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Menggunakan font Inter */
        body { font-family: 'Inter', sans-serif; }
        
        /* Warna spesifik untuk navigasi dan footer */
        .bg-nav-footer { background-color: #adb5bd; /* Abu-abu sedang */ }
        .bg-admin-btn { background-color: #6c757d; /* Abu-abu gelap */ }
        
        /* Styling baris tabel spesifik */
        .status-hilang { background-color: #dc3545; color: white; } /* Merah */
        .status-belum-hantar { background-color: #ffc107; } /* Kuning/Oranye */
        .status-selesai { background-color: #28a745; color: white; } /* Hijau */

        /* Untuk memastikan footer selalu di bawah */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content-area {
            flex-grow: 1;
            padding-bottom: 50px; /* Jarak sebelum footer */
        }

        /* Override Tailwind untuk memastikan tabel header berwarna gelap */
        .data-table th {
            background-color: #6c757d;
            color: white;
            padding: 12px;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        /* logo header*/
        .logo-container {
            height: 60px;
            width: auto;
        }

        .logo-container img {
            max-height: 60px;
            width: auto;
            object-fit: contain;
        }

        /* Gaya untuk Background dengan Overlay */
        .hero-section {
            background-image: url("{{ asset('img/algazel_bg.jpeg') }}");
            background-size: cover;
            background-position: center;
            height: 80vh; /* Mengambil 80% dari ketinggian viewport */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-align: center;
        }

        /* Dark Overlay */
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

        /* Pastikan kandungan di atas overlay */
        .content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 1rem;
        }

        /* Styling for the logo text/image */
        .logo-text {
            color: #cc3333; /* Warna merah seperti KV Vokasional */
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Styling for the login buttons */
        .login-btn-admin {
            background-color: #cc3333; /* Merah untuk Admin */
            color: white;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        .login-btn-admin:hover {
            background-color: #a32929;
        }
        .login-btn-staff {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        .login-btn-staff:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Responsive Title Adjustment */
        @media (max-width: 768px) {
            .main-title {
                font-size: 1.75rem; /* Saiz lebih kecil untuk mudah alih */
            }
        }
        

    </style>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="flex justify-between items-center px-8 py-4 bg-white shadow-md">
        <div class="flex items-center">
            <div class="logo-container">
                <img src="{{ asset('img/kv.png') }}" alt="KV Logo">
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-admin-btn text-white px-4 py-1.5 rounded-full text-sm font-semibold flex items-center shadow-md">
                <i class="fas fa-user-circle mr-2"></i> <a href="{{url('/login')}}">LOG IN</a> 
            </button>
        </div>
    </header>
    

    <!-- Main Content Area -->
            <!-- HERO SECTION / KANDUNGAN UTAMA -->
            <section class="hero-section">
                <div class="content max-w-5xl mx-auto">
                    <!-- Tajuk Utama -->
                    <h1 class="main-title text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4 leading-tight text-white shadow-text">
                        SELAMAT DATANG KE SISTEM PEMINJAMAN DAN PEMULANGAN BUKU
                    </h1>
                    <p class="text-xl sm:text-2xl font-light mb-12 text-gray-200">
                        AL-GAZEL KVDSZAZI
                    </p>

                    <!-- Butang Log Masuk (Admin & Staff) -->
                     
                    <div class="flex flex-wrap justify-center space-x-4 space-y-4 sm:space-y-0 mt-8">
                        <a href="{{url('/login')}}"><button data-role="Admin" class="login-btn-admin px-8 py-3 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                            Log In
                        </button></a>
                    </div>
                </div>
            </section>

    <!-- Footer -->
    <footer class="bg-nav-footer w-full py-12 mt-auto">
        <div class="text-center text-black text-xl font-bold">
            © {{ date('Y') }} SPPB — Semua hak cipta terpelihara
        </div>
    </footer>
    
</body>
</html>