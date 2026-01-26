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
        body { font-family: 'Inter', sans-serif; }
        
        .bg-nav-footer { background-color: #adb5bd;  }
        .bg-admin-btn { background-color: #6c757d; }
        
        /* Styling baris tabel spesifik */
        .status-hilang { background-color: #dc3545; color: white; } 
        .status-belum-hantar { background-color: #ffc107; }
        .status-selesai { background-color: #28a745; color: white; } 

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

        /* Override Tailwind untuk memastikan tabel header berwarna gelap */
        .data-table th {
            background-color: #4d4d4d;
            color: white;
            padding: 12px;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        /* Dashboard/Content Box */
        .dashboard-area {
            background-color: hsl(0, 0%, 98%);
            padding: 20px 30px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
        }
        
        .welcome-message {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .list-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
        }

        /* Filter dan Aksi */
        .action-row {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 15px;
            background-color: #f8f9fa;
        }

        .search-box input {
            border: none;
            outline: none;
            padding-left: 5px;
            background: none;
        }

        .search-box::before {
            content: "🔍"; 
            margin-right: 5px;
            color: #6c757d;
        }
        
        .filter-buttons button {
            padding: 8px 15px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            transition: all 0.2s;
        }

        .filter-buttons button:hover {
            opacity: 0.9;
        }

        .filter-buttons .active {
            background-color: #6c757d; 
            color: white;
            border-color: #6c757d;
        }

        .filter-buttons button:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .filter-buttons button:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            margin-left: -1px; /* Gabungkan tombol */
        }

        .add-button {
            background-color: #ffffff;
            color: #495057;
            border: 1px solid #ced4da;
            padding: 8px 15px;
            border-radius: 5px;
            margin-left: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .add-button:hover {
            background-color: #e9ecef;
        }

        /* Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .data-table th, .data-table td {
            padding: 10px;
            border-bottom: 1px solid #999;
            font-size: 14px;
        }

        .data-table th {
            background-color: #bdbdbd;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .data-table td a {
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            display: block; /* Agar update/delete berada di baris terpisah */
        }
        
        .data-table td a.update {
            color: #007bff; 
            margin-bottom: 2px;
        }
        
        .data-table td a.delete {
            color: #dc3545; 
        }

        /* Styling untuk kotak berbingkai (form dan list) */
        .bordered-section {
            border: 2px solid #333; /* Border hitam */
            background-color: #f1f1f1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-height: 350px; /* Tinggi minimum untuk visual */
        }

        /* Keep users list table white */
        .bordered-section table {
            background-color: white;
        }

        .bordered-section table thead {
            background-color: white;
        }

        .bordered-section table tbody tr {
            background-color: white;
        }

        .bordered-section table th {
            background-color: white;
            color: #333;
        }

        /* Styling Form Input */
        .form-row {
            display: grid;
            grid-template-columns: 100px 1fr; /* Lebar label dan input */
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-row label {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
            color: #444;
        }
        .form-row input, .form-row select {
            border: 1px solid #ccc;
            padding: 8px;
            border-radius: 4px;
            width: 100%;
        }

        /* Styling List Header/Rows */
        .list-header, .list-row {
            display: grid;
            grid-template-columns: 1fr 1fr 80px; /* Username, Password, Padam */
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
        }
        .list-header {
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 10px;
        }
        .list-row:not(:last-child) {
            border-bottom: 1px solid #eee;
        }

        /* Dropdown logout styling */
        .logout-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            border-radius: 5px;
            z-index: 1000;
            margin-top: 10px;
            min-width: 100px;
        }

        .logout-dropdown.show {
            display: block;
        }

        .logout-dropdown button {
            width: 100%;
            padding: 8px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }

        .logout-dropdown button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body class="bg-gray-100" style="background-color: #c5eefc;">

    <!-- Header -->
    <header class="flex justify-between items-center px-8 py-4 bg-gradient-to-r from-blue-300 to-indigo-600 shadow-md relative">
        <div class="logo-container">
            <img src="{{ asset('img/kv.png') }}" alt="KV Logo">
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button id="userBtn" class="bg-admin-btn text-white px-4 py-1.5 rounded-full text-sm font-semibold flex items-center shadow-md cursor-pointer hover:bg-gray-700">
                    <i class="fas fa-user-circle mr-2"></i> @yield('user')
                </button>
                <div id="logoutDropdown" class="logout-dropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full">
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Bar -->
    @yield('nav')

    <!-- Main Content Area -->
    <main class="main-content-area px-8 py-8">
        <div class="max-w-4xl mx-auto">

        <!-- Date & Time - Diperbarui secara real-time oleh JavaScript -->
            <div class="text-sm text-gray-600 mb-6">
                <p id="currentDate">Date:</p>
                <p id="currentTime">Time:</p>
            </div>


        @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-nav-footer w-full py-12 mt-auto">
        <div class="text-center text-black text-xl font-bold">
            © {{ date('Y') }} SPPB — Semua hak cipta terpelihara
        </div>
    </footer>

    <!-- JavaScript untuk waktu real-time -->
    <script>
        // Fungsi untuk mendapatkan tarikh dan masa semasa
        function updateDateTime() {
            const now = new Date();
            
            // Format Tarikh (contoh: 27/11/2025)
            const dateOptions = { day: '2-digit', month: '2-digit', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('ms-MY', dateOptions).replace(/\//g, '/');

            // Format Masa (contoh: 09:30 AM/PM)
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            const formattedTime = now.toLocaleTimeString('en-US', timeOptions);

            // Update DOM
            document.getElementById('currentDate').textContent = `Date: ${formattedDate}`;
            document.getElementById('currentTime').textContent = `Time: ${formattedTime.toUpperCase()}`;
        }

        // Jalankan fungsi sekali saat dimuat
        updateDateTime();

        // Jalankan fungsi setiap 1 saat
        setInterval(updateDateTime, 1000);

        // Dropdown logout toggle
        document.getElementById('userBtn').addEventListener('click', function() {
            const dropdown = document.getElementById('logoutDropdown');
            dropdown.classList.toggle('show');
        });

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function(event) {
            const userBtn = document.getElementById('userBtn');
            const dropdown = document.getElementById('logoutDropdown');
            
            if (!userBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>

</body>
</html>