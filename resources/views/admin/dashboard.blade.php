@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

<style>
    .nav-dashboard a {
        background-color: #d1d5db; /* Warna latar belakang abu-abu muda */
    }
</style>
        <div class="text-center mb-6"><h2 class="text-xl font-medium text-gray-700">WELCOME ADMIN</h2>
            <h1 class="text-2xl font-bold text-gray-800 mt-1">DASHBOARD</h1>
        </div>
                <!-- 3. 4 SMALL BOXES (Stats Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    
                    <!-- Box 1: Total Book -->
                    <a href="{{ url('/book') }}" class="block bg-white p-6 rounded-xl shadow-lg border-t-4 border-blue-500 hover:shadow-xl transition duration-300">
                         <div class="flex items-center justify-between">
                             <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Book</p>
                             <span class="text-blue-500">
                                 <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H10z" clip-rule="evenodd"></path></svg>
                             </span>
                         </div>
                         <p class="mt-2 text-4xl font-extrabold text-gray-900">{{ $totalBooks }}</p>
                    </a>

                    <!-- Box 2: Total Student -->
                    <a href="{{ url('/student') }}" class="block bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition duration-300">
                         <div class="flex items-center justify-between">
                             <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Student</p>
                             <span class="text-green-500">
                                 <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                             </span>
                         </div>
                         <p class="mt-2 text-4xl font-extrabold text-gray-900">{{ $totalStudents }}</p>
                    </a>

                    <!-- Box 3: Total Teacher -->
                    <a href="{{ url('/teacher') }}" class="block bg-white p-6 rounded-xl shadow-lg border-t-4 border-purple-500 hover:shadow-xl transition duration-300">
                         <div class="flex items-center justify-between">
                             <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Teacher</p>
                             <span class="text-purple-500">
                                 <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                             </span>
                         </div>
                         <p class="mt-2 text-4xl font-extrabold text-gray-900">{{ $totalTeachers }}</p>
                    </a>

                    <!-- Box 4: Total Borrow -->
                    <a href="{{ url('/record') }}" class="block bg-white p-6 rounded-xl shadow-lg border-t-4 border-yellow-500 hover:shadow-xl transition duration-300">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total borrow</p>
                            <span class="text-yellow-500">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0z"></path><path fill-rule="evenodd" d="M11 9.922C16.326 12.33 20 15.655 20 18H0c0-2.345 3.674-5.67 9-8.078V9.922zm0 0a6 6 0 100-3.844v3.844z" clip-rule="evenodd"></path></svg>
                            </span>
                        </div>
                        <p class="mt-2 text-4xl font-extrabold text-gray-900">{{ $totalBorrow ?? 0 }}</p>
                    </a>

                    <!-- Box 5: Still Not Return -->
                    <a href="{{ url('/record') }}" class="block bg-white p-6 rounded-xl shadow-lg border-t-4 border-red-500 hover:shadow-xl transition duration-300">
                         <div class="flex items-center justify-between">
                             <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">still not return</p>
                             <span class="text-red-500">
                                 <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-2-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                             </span>
                         </div>
                         <p class="mt-2 text-4xl font-extrabold text-gray-900">{{ $notReturned }}</p>
                         <p class="text-sm text-red-500 mt-1"></p>
                    </a>
                </div>

                <!-- Main Content Placeholder (Example sections) -->
                <div class="space-y-6">
                    <!-- Chart/Table 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Recent Activity Log</h2>
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
                                <tr class="border-t border-gray-200 hover:bg-gray-50 {{ $r['row_class'] ?? '' }}">
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