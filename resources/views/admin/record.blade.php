@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')
<style>
    .nav-record a {
        background-color: #d1d5db; /* Warna latar belakang abu-abu muda */
    }
</style>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Welcome & Title -->
                <div class="text-center mb-6">
                    <h2 class="text-xl font-medium text-gray-700">WELCOME ADMIN</h2>
                    <h1 class="text-2xl font-bold text-gray-800 mt-1">BORROWING RECORDS</h1>
                </div>

                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table class="data-table w-full border-collapse border border-gray-200 rounded-lg">
                        <thead>
                            <tr>
                                <th class="rounded-tl-lg px-4 py-2">#</th>
                                <th class="px-4 py-2">Borrower Name</th>
                                <th class="px-4 py-2">Book Title</th>
                                <th class="px-4 py-2">Borrowed Date</th>
                                <th class="px-4 py-2">Due Date</th>
                                <th class="px-4 py-2">Returned Date</th>
                                <th class="rounded-tr-lg px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records ?? [] as $i => $r)
                                <tr class="border-t border-gray-200 {{ $r['row_class'] ?? '' }}">
                                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold">{{ $r['borrower'] }}</td>
                                    <td class="px-4 py-3">{{ $r['book'] }}</td>
                                    <td class="px-4 py-3">{{ $r['borrowed_date'] }}</td>
                                    <td class="px-4 py-3">{{ $r['due_date'] }}</td>
                                    <td class="px-4 py-3">{{ $r['returned_date'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $r['status'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500">Tiada rekod peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

@endsection