@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

<div class="text-center mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Kemaskini Pelajar</h1>
</div>

<div class="bordered-section p-8 bg-white rounded-lg shadow">
    <div class="form-container max-w-xl mx-auto">
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

        <form action="{{ url('/student/'.$student->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="form-row">
                <label for="no_matrik" class="block text-sm font-medium text-gray-700">No Matrik / ID</label>
                <input id="no_matrik" name="no_matrik" type="text" required
                    value="{{ old('no_matrik', $student->no_matrik) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="form-row">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input id="name" name="name" type="text" required
                    value="{{ old('name', $student->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="form-row">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mel</label>
                <input id="email" name="email" type="email"
                    value="{{ old('email', $student->email) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="form-row">
                <label for="phone" class="block text-sm font-medium text-gray-700">No Telefon</label>
                <input id="phone" name="phone" type="text"
                    value="{{ old('phone', $student->phone) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="form-row">
                <label for="course" class="block text-sm font-medium text-gray-700">Program</label>
                <input id="course" name="course" type="text"
                    value="{{ old('course', $student->course) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="form-row">
                <label for="kohort" class="block text-sm font-medium text-gray-700">Tahun Kemasukan</label>
                <input id="kohort" name="kohort" type="text"
                    value="{{ old('kohort', $student->kohort) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="space-x-2">
                    <a href="{{ url('/student') }}"
                    class="inline-block px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-block px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
