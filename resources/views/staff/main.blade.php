@extends('layouts.app')
@extends('layouts.staffheader')
@section('content')
    <!-- KANDUNGAN UTAMA -->
        <!-- Tajuk Utama -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl text-center font-extrabold tracking-tight mb-16 mt-12 text-gray-900 leading-tight">
            SELAMAT DATANG KE PUSAT SUMBER AL-GAZEL
        </h1>

        <!-- KAD-KAD TINDAKAN -->
        <div class="flex flex-col md:flex-row justify-center items-stretch space-y-8 md:space-y-0 md:space-x-12">

            <!-- Kad 1: PINJAM BUKU -->
            <a href="{{url('/borrow')}}" data-action="Pinjam Buku" class="action-card group w-full max-w-xs mx-auto p-6 border-4 border-gray-800 rounded-xl shadow-2xl transition duration-300 transform hover:scale-[1.02] hover:shadow-gray-400 cursor-pointer bg-white">
                <div class="text-xl text-center font-bold mb-4 text-gray-800 group-hover:text-indigo-700 uppercase">
                    PINJAM BUKU
                </div>
                <!-- Placeholder seperti dalam imej -->
                <div class="w-48 h-64 mx-auto bg-gray-100 border-2 border-dashed border-gray-500 flex items-center justify-center rounded-lg text-gray-500 text-sm">
                    <img src="{{ asset('img/borrow.jpg') }}" alt="KV Logo">
                </div>
            </a>

            <!-- Kad 2: PULANG BUKU -->
            <a href="{{url('/return')}}" data-action="Pulang Buku" class="action-card group w-full max-w-xs mx-auto p-6 border-4 border-gray-800 rounded-xl shadow-2xl transition duration-300 transform hover:scale-[1.02] hover:shadow-gray-400 cursor-pointer bg-white">
                <div class="text-xl text-center font-bold mb-4 text-gray-800 group-hover:text-indigo-700 uppercase">
                    PULANG BUKU
                </div>
                <!-- Placeholder seperti dalam imej -->
                <div class="w-48 h-64 mx-auto bg-gray-100 border-2 border-dashed border-gray-500 flex items-center justify-center rounded-lg text-gray-500 text-sm">
                    <img src="{{ asset('img/images.png') }}" alt="KV Logo">
                </div>
            </a>
        </div>

        <!-- Pautan Bawah (Footer Action) -->

            

        <h2 class="text-2xl font-extrabold text-center text-blue-800 mb-8 tracking-widest mt-10">
            <a href="#senarai-buku" data-action="Senarai Buku" class="action-card text-lg font-extrabold text-blue-700 hover:text-blue-900 transition duration-200">
                vv SENARAI BUKU vv
            </a>
        </h2>

        <!-- BAHAGIAN SENARAI BUKU (BARU) -->
        <section id="senarai-buku" class="mt-16 pt-10 border-t border-gray-300">
            <!-- Kontena Senarai Buku - Lebar Penuh (Max-w-4xl) -->
            <div class="max-w-4xl mx-auto text-left bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                
                <!-- Search Bar -->
                <div class="flex items-center space-x-3 mb-6 p-2 border border-gray-300 rounded-lg shadow-sm w-full max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <form id="main-book-search-form" onsubmit="return false;" class="w-full">
                        <input id="main-book-search" type="text" placeholder="Search" class="w-full text-gray-700 placeholder-gray-400 focus:outline-none" autocomplete="off" />
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-300">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">NAMA BUKU</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Status</th>
                            </tr>
                        </thead>
                        <tbody id="main-book-table-body" class="bg-white divide-y divide-gray-200">
                            @include('staff._main_book_rows', ['books' => $books])
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    
    <!-- MODAL POPUP (Pengganti alert()) -->
    <div id="custom-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white p-6 rounded-lg shadow-2xl max-w-sm w-full transform transition-all duration-300 scale-95 opacity-0" id="modal-content-container">
            <h3 class="text-xl font-bold mb-3 text-gray-800" id="modal-title">Makluman</h3>
            <p class="text-gray-600 mb-6" id="modal-message">Ini adalah mesej.</p>
            <div class="flex justify-end">
                <button id="modal-close-btn" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        const modal = document.getElementById('custom-modal');
        const modalContainer = document.getElementById('modal-content-container');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modal-message');
        const modalCloseBtn = document.getElementById('modal-close-btn');

        // Fungsi untuk menunjukkan modal
        function showModal(title, message) {
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Animasi masuk
            setTimeout(() => {
                modalContainer.classList.remove('scale-95', 'opacity-0');
                modalContainer.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Fungsi untuk menyembunyikan modal
        function hideModal() {
            // Animasi keluar
            modalContainer.classList.remove('scale-100', 'opacity-100');
            modalContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300); // Tunggu animasi selesai
        }

        // Event listener untuk menutup modal
        modalCloseBtn.addEventListener('click', hideModal);
        
        // Event listener untuk klik di luar modal (tutup)
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal();
            }
        });

        // Event listener untuk butang Log Keluar
        document.getElementById('logout-btn').addEventListener('click', function(event) {
            event.preventDefault();
            showModal('Tindakan', 'Anda telah cuba Log Keluar. Fungsi ini memerlukan sistem pengesahan (authentication) sebenar.');
        });

        // Event listener untuk kad-kad tindakan (Pinjam, Pulang, Senarai)
        document.querySelectorAll('.action-card').forEach(card => {
            card.addEventListener('click', function(event) {
                event.preventDefault();
                const action = this.getAttribute('data-action');
                showModal('Tindakan', `Anda telah mengklik pada: "${action}". Pautan ini akan membawa anda ke halaman fungsi yang berkenaan.`);
            });
        });

    </script>
    <script>
        // AJAX search + pagination for main book list
        (function () {
            const input = document.getElementById('main-book-search');
            const tbody = document.getElementById('main-book-table-body');
            let timer = null;

            function fetchRows(url) {
                const base = "{{ route('main.rows') }}";
                const fetchUrl = url || (base + '?search=' + encodeURIComponent(input.value || ''));
                fetch(fetchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        tbody.innerHTML = html;
                        try {
                            const u = new URL(fetchUrl, window.location.origin);
                            window.history.replaceState({}, '', '/main' + u.search);
                        } catch (e) {}
                    })
                    .catch(err => console.error('Failed fetching main book rows', err));
            }

            if (input) {
                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(() => fetchRows(), 300);
                });
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(timer);
                        fetchRows();
                    }
                });
            }

            // Extra guard: prevent the search form from submitting (in case of other JS errors)
            const mainSearchForm = document.getElementById('main-book-search-form');
            if (mainSearchForm) {
                mainSearchForm.addEventListener('submit', function (e) { e.preventDefault(); });
            }

            // Global Enter guard when focus is on the search input
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && document.activeElement && document.activeElement.id === 'main-book-search') {
                    e.preventDefault();
                    clearTimeout(timer);
                    fetchRows();
                }
            });

            document.addEventListener('click', function (e) {
                const a = e.target.closest && e.target.closest('a');
                if (!a) return;
                if (!tbody.contains(a)) return;
                if (a.href && a.href.indexOf('page=') !== -1) {
                    e.preventDefault();
                    fetchRows(a.href);
                }
            });

            document.addEventListener('DOMContentLoaded', function () {
                const params = new URLSearchParams(window.location.search);
                if (params.get('search') || params.get('page')) fetchRows();
            });
        })();
    </script>
    
@endsection