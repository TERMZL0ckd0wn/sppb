@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

<style>
    .nav-book a {
        background-color: #d1d5db; /* Warna latar belakang abu-abu muda */
    }
</style>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <!-- Welcome & Title -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-medium text-gray-700">WELCOME ADMIN</h2>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">BOOKS RECORDS</h1>
    </div>

                <!-- Search Bar and Add Button -->
                <div class="action-row flex items-center justify-between mb-4">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('book.index') }}" class="search-box" onsubmit="return false;">
                        <input type="text"
                            id="book-search-input"
                            name="search"
                            placeholder="Search"
                            value="{{ $search ?? '' }}"
                            class="px-3 py-2 border rounded"
                            autocomplete="off">
                    </form>

                    <!-- Tambah Buku Button -->
                    <a href="{{ url('/addbook') }}">
                        <button class="add-button">+ ADD BOOK</button>
                    </a>
                </div>
                
                <!-- borrowed (Kuning) -->
                <!-- available (Hijau) -->
                <!-- lost (Merah) -->


                <!-- Data Table (Senarai Buku) -->
                <div class="overflow-x-auto">
                    <table class="data-table w-full border-collapse border border-gray-200 rounded-lg shadow-md">
                        <thead>
                            <tr class="text-left">
                                <th class="rounded-tl-lg w-10">#</th>
                                <th class="w-24">ID</th>
                                <th class="w-48">NAMA BUKU</th>
                                <th class="w-24">STATUS</th>
                                <th class="rounded-tr-lg w-32">EDIT</th>
                            </tr>
                        </thead>
                        <tbody id="book-table-body">
                            @include('admin._book_rows', ['books' => $books])
                        </tbody>
                    </table>
                </div>
            </div>
    <script>
        // AJAX search for books: fetch partial rows and replace tbody
        let searchTimer = null;
        const searchInput = document.getElementById('book-search-input');

        function fetchBookRows(search) {
            const url = new URL("{{ route('book.rows') }}", window.location.origin);
            if (search) url.searchParams.set('search', search);

            fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const tbody = document.getElementById('book-table-body');
                    tbody.innerHTML = html;
                    // Update URL without reloading
                    window.history.replaceState({}, '', '/book' + url.search);
                })
                .catch(err => console.error('Fetch book rows error', err));
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const search = this.value.trim();
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => fetchBookRows(search), 300);
            });

            // Prevent Enter key from submitting the form
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimer);
                    fetchBookRows(this.value.trim());
                }
            });
        }

        // Delegate pagination link clicks inside the table body
        document.addEventListener('click', function (e) {
            const a = e.target.closest && e.target.closest('a');
            if (!a) return;
            const tbody = document.getElementById('book-table-body');
            if (!tbody.contains(a)) return;
            if (a.href && a.href.indexOf('page=') !== -1) {
                e.preventDefault();
                fetch(a.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => { tbody.innerHTML = html; })
                    .catch(err => console.error('Pagination fetch failed', err));
            }
        });

        // on page load apply existing search via AJAX
        document.addEventListener('DOMContentLoaded', function () {
            if (searchInput && searchInput.value.trim() !== '') fetchBookRows(searchInput.value.trim());
        });
    </script>
@endsection
    