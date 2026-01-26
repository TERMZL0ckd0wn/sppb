@extends ('layouts.app')
@extends('layouts.navadmin')
@section ('content')
<style>
    .nav-person a {
        background-color: #d1d5db; /* Warna latar belakang abu-abu muda */
    }
</style>  
<div class="dashboard-area">
    <div class="text-center mb-6">
        <h2 class="text-xl font-medium text-gray-700">WELCOME ADMIN</h2>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">BORROWER RECORDS</h1>
    </div>

    <!-- Baris Filter dan Tambah -->
    <div class="action-row flex items-center justify-between">

        <!-- Search Box -->
        <form method="GET" action="{{ url('/teacher') }}" class="search-box" onsubmit="return false;">
            <input type="text"
                id="teacher-search-input"
                name="q"
                placeholder="Search"
                value="{{ $q }}"
                class="px-3 py-2 border rounded"
                autocomplete="off">
        </form>

        <div class="filter-buttons">
            <button><a href="{{ url('/student') }}">STUDENT</a></button>
            <button class="active"><a href="{{ url('/teacher') }}">TEACHER</a></button>
        </div>

        <a href="{{ url('/addteacher') }}">
            <button class="add-button">+ ADD BORROWER</button>
        </a>

    </div>

    <!-- Tabel Data -->
    <div class="overflow-x-auto mt-4">
        <table class="data-table w-full border-collapse">
            <thead>
                    <tr class="bg-gray-100">
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">NAME</th>
                    <th class="p-2 border">E-MAIL</th>
                    <th class="p-2 border">PHONE NUMBER</th>
                    <th class="p-2 border">DEPARTMENT</th>
                    <th class="p-2 border">EDIT</th>
                </tr>
            </thead>

            <tbody id="teacher-table-body">
                @include('admin._teacher_rows', ['teachers' => $teachers])
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{-- Pagination is rendered inside the rows partial for AJAX handling --}}
    </div>
</div>

<script>
    // Live client-side filter for teachers (filters only current page rows)
    function filterTeachers() {
        const input = document.getElementById('teacher-search-input');
        const filter = (input.value || '').toUpperCase().trim();
        const tbody = document.getElementById('teacher-table-body');
        const rows = tbody.getElementsByTagName('tr');
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            if (row.querySelectorAll('td').length === 1) {
                row.style.display = filter ? 'none' : '';
                if (row.style.display === '') visibleCount++;
                continue;
            }

            const idText = row.querySelector('.teacher-col-id')?.textContent.toUpperCase() ?? '';
            const nameText = row.querySelector('.teacher-col-name')?.textContent.toUpperCase() ?? '';
            const emailText = row.querySelector('.teacher-col-email')?.textContent.toUpperCase() ?? '';
            const phoneText = row.querySelector('.teacher-col-phone')?.textContent.toUpperCase() ?? '';
            const deptText = row.querySelector('.teacher-col-department')?.textContent.toUpperCase() ?? '';

            const match = !filter || idText.indexOf(filter) > -1 || nameText.indexOf(filter) > -1 || emailText.indexOf(filter) > -1 || phoneText.indexOf(filter) > -1 || deptText.indexOf(filter) > -1;
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        }

        const noDataId = 'teachers-no-results';
        let noDataRow = document.getElementById(noDataId);
        if (visibleCount === 0) {
            if (!noDataRow) {
                noDataRow = document.createElement('tr');
                noDataRow.id = noDataId;
                noDataRow.innerHTML = '<td colspan="7" class="p-4 text-center text-sm text-gray-500">Tiada rekod pensyarah (hasil carian).</td>';
                tbody.appendChild(noDataRow);
            }
        } else {
            if (noDataRow) noDataRow.remove();
        }
    }

    // AJAX search: fetch partial rows and replace tbody
    let searchTimer = null;
    const searchInput = document.getElementById('teacher-search-input');

    function fetchTeacherRows(q) {
        const url = new URL("{{ route('teacher.rows') }}", window.location.origin);
        if (q) url.searchParams.set('q', q);

        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const tbody = document.getElementById('teacher-table-body');
                tbody.innerHTML = html;
            })
            .catch(err => console.error('Fetch teacher rows error', err));
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim();
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => fetchTeacherRows(q), 300);
        });

        // Prevent Enter key from submitting the form
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                fetchTeacherRows(this.value.trim());
            }
        });
    }

    // Delegate pagination link clicks inside the table body
    document.addEventListener('click', function (e) {
        const a = e.target.closest && e.target.closest('a');
        if (!a) return;
        const tbody = document.getElementById('teacher-table-body');
        if (!tbody.contains(a)) return;
        if (a.href && a.href.indexOf('page=') !== -1) {
            e.preventDefault();
            fetch(a.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => { tbody.innerHTML = html; })
                .catch(err => console.error('Pagination fetch failed', err));
        }
    });

    // on page load apply existing q via AJAX
    document.addEventListener('DOMContentLoaded', function () {
        if (searchInput && searchInput.value.trim() !== '') fetchTeacherRows(searchInput.value.trim());
    });
</script>

@endsection
