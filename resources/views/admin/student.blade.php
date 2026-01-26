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
        <form method="GET" action="{{ url('/student') }}" class="search-box" onsubmit="return false;">
            <input type="text"
                id="student-search-input"
                name="q"
                placeholder="Search"
                value="{{ $q }}"
                class="px-3 py-2 border rounded"
                autocomplete="off">
        </form>

        <div class="filter-buttons">
            <button class="active"><a href="{{ url('/student') }}">STUDENT</a></button>
            <button><a href="{{ url('/teacher') }}">TEACHER</a></button>
        </div>

        <a href="{{ url('/addstudent') }}">
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
                    <th class="p-2 border">PROGRAM</th>
                    <th class="p-2 border">YEAR ENTERENCE</th>
                    <th class="p-2 border">EDIT</th>
                </tr>
            </thead>
            <tbody id="student-table-body">
                @forelse($students as $i => $s)
                    <tr class="@if($i%2==0) bg-white @else bg-gray-50 @endif">
                        <td class="p-2 border">{{ $students->firstItem() + $i }}</td>
                        <td class="p-2 border whitespace-nowrap student-col-id">{{ $s->no_matrik ?? $s->student_id }}</td>
                        <td class="p-2 border student-col-name">{{ $s->name }}</td>
                        <td class="p-2 border whitespace-nowrap student-col-email">{{ $s->email }}</td>
                        <td class="p-2 border whitespace-nowrap student-col-phone">{{ $s->phone ?? '-' }}</td>
                        <td class="p-2 border student-col-course">{{ $s->course ?? '-' }}</td>
                        <td class="p-2 border student-col-kohort">{{ $s->kohort ?? '-' }}</td>
                        <td class="p-2 border">
                            <a href="{{ url('/student/'.$s->id.'/edit') }}" class="text-indigo-600 hover:underline">EDIT</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-sm text-gray-500">Tiada rekod pelajar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
 
     <!-- Pagination -->
     <div class="mt-4">
         {{ $students->links() }}
     </div>
</div>

<script>
    // Live client-side filter similar to staff/borrow page.
    // This filters only the rows currently on the page (use server search for full DB search).
    function filterStudents() {
        const input = document.getElementById('student-search-input');
        const filter = (input.value || '').toUpperCase().trim();
        const tbody = document.getElementById('student-table-body');
        const rows = tbody.getElementsByTagName('tr');
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];

            // skip empty-row message row
            if (row.querySelectorAll('td').length === 1) {
                row.style.display = filter ? 'none' : '';
                if (row.style.display === '') visibleCount++;
                continue;
            }

            const idCell = row.querySelector('.student-col-id');
            const nameCell = row.querySelector('.student-col-name');
            const emailCell = row.querySelector('.student-col-email');
            const phoneCell = row.querySelector('.student-col-phone');
            const courseCell = row.querySelector('.student-col-course');
            const kohortCell = row.querySelector('.student-col-kohort');

            const idText = idCell ? idCell.textContent.toUpperCase() : '';
            const nameText = nameCell ? nameCell.textContent.toUpperCase() : '';
            const emailText = emailCell ? emailCell.textContent.toUpperCase() : '';
            const phoneText = phoneCell ? phoneCell.textContent.toUpperCase() : '';
            const courseText = courseCell ? courseCell.textContent.toUpperCase() : '';
            const kohortText = kohortCell ? kohortCell.textContent.toUpperCase() : '';

            const match = !filter ||
                idText.indexOf(filter) > -1 ||
                nameText.indexOf(filter) > -1 ||
                emailText.indexOf(filter) > -1 ||
                phoneText.indexOf(filter) > -1 ||
                courseText.indexOf(filter) > -1 ||
                kohortText.indexOf(filter) > -1;

            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        }

        // if no rows visible show a friendly message row (insert/remove)
        const noDataId = 'students-no-results';
        let noDataRow = document.getElementById(noDataId);
        if (visibleCount === 0) {
            if (!noDataRow) {
                noDataRow = document.createElement('tr');
                noDataRow.id = noDataId;
                noDataRow.innerHTML = '<td colspan="8" class="p-4 text-center text-sm text-gray-500">Tiada rekod pelajar (hasil carian).</td>';
                tbody.appendChild(noDataRow);
            }
        } else {
            if (noDataRow) noDataRow.remove();
        }
    }

    // AJAX search: fetch partial rows and replace tbody
    let searchTimer = null;
    const searchInput = document.getElementById('student-search-input');

    function fetchStudentRows(q) {
        const url = new URL("{{ route('student.rows') }}", window.location.origin);
        if (q) url.searchParams.set('q', q);

        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const tbody = document.getElementById('student-table-body');
                tbody.innerHTML = html;
            })
            .catch(err => console.error('Fetch rows error', err));
    }

    // debounce input
    searchInput.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => fetchStudentRows(q), 300);
    });

    // Prevent Enter key from submitting or reloading the page
    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // trigger the fetch immediately
                clearTimeout(searchTimer);
                fetchStudentRows(this.value.trim());
            }
        });
    }

    // on page load apply existing q via AJAX
    document.addEventListener('DOMContentLoaded', function () {
        if (searchInput && searchInput.value.trim() !== '') fetchStudentRows(searchInput.value.trim());
    });
</script>

@endsection