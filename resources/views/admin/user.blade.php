@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')
<style>
    .nav-user a {
        background-color: #d1d5db; /* Warna latar belakang abu-abu muda */
    }
</style>
<div class="flex justify-center space-x-6">

    <!-- Left Column: Tambah Pengguna (Form) -->
    <div class="w-1/2">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">Add User</h1>
        </div>
        <div class="bordered-section p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-800">
                    <strong class="block font-semibold">Terdapat ralat:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.store') }}">
                @csrf
                
                <!-- Username -->
                <div class="form-row">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                </div>

                <!-- Password -->
                <div class="form-row">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <!-- Sebagai (Level) -->
                <div class="form-row">
                    <label for="level">Role:</label>
                    <select id="level" name="level">
                        <option value="admin" {{ old('level') === 'admin' ? 'selected' : '' }}>ADMIN</option>
                        <option value="staff" {{ old('level') === 'staff' ? 'selected' : '' }}>STAFF</option>
                    </select>
                </div>

                <!-- Button -->
                <div class="flex justify-end mt-12">
                    <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-8 rounded-md shadow-md transition duration-150">
                        SUBMIT
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Right Column: Senarai Pengguna (List) -->
    <div class="w-1/2">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">List of Users</h1>
        </div>
        <!-- The list is structured using table for better organization -->
        <div class="bordered-section overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-300">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 w-1/4">Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 w-1/4">Password</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700 w-1/4">Level</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700 w-1/4">Padam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-3 font-semibold text-gray-800">{{ $user->username }}</td>
                            <td class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <span class="password-text text-gray-700" data-user-id="{{ $user->id }}" data-password="{{ $user->decrypted_password ?? '' }}">••••••••</span>
                                    <button type="button" class="toggle-password-btn text-gray-500 hover:text-gray-800 transition" data-user-id="{{ $user->id }}" onclick="togglePassword({{ $user->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 eye-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-center text-gray-700">{{ strtoupper($user->level) }}</td>
                            <td class="px-6 py-3 text-center">
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Padam pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Padam</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tiada rekod pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function togglePassword(userId) {
        const passwordText = document.querySelector(`[data-user-id="${userId}"].password-text`);
        const btn = document.querySelector(`[data-user-id="${userId}"].toggle-password-btn`);
        const actualPassword = passwordText.getAttribute('data-password');
        
        if (passwordText.textContent === '••••••••') {
            // Show password
            passwordText.textContent = actualPassword || '(tidak ada)';
            btn.classList.add('text-blue-600');
        } else {
            // Hide password
            passwordText.textContent = '••••••••';
            btn.classList.remove('text-blue-600');
        }
    }
</script>

@endsection