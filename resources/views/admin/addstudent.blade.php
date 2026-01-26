@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Peminjam</h1>
            </div>

            <div class="mb-4">
                <button type="button" onclick="history.back()" class="inline-flex items-center px-3 py-2 bg-white/20 text-gray-700 rounded-md hover:bg-white/30 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
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

                    <form action="{{ route('student.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="form-row">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input id="name" name="name" type="text" required
                                value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
                        </div>

                        <div class="form-row">
                            <label for="no_matrik" class="block text-sm font-medium text-gray-700">No Matrik</label>
                            <input id="no_matrik" name="no_matrik" type="text" required
                                value="{{ old('no_matrik') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
                        </div>

                        <div class="form-row">
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mel</label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
                        </div>

                        <div class="form-row">
                            <label for="phone" class="block text-sm font-medium text-gray-700">No Telefon</label>
                            <input id="phone" name="phone" type="text"
                                value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
                        </div>

                        <div class="form-row">
                            <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                            <select id="course" name="course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2">
                                <option value="">-- Pilih Program --</option>
                                <option value="BPR" {{ old('course')=='BPR' ? 'selected' : '' }}>BPR</option>
                                <option value="BPP" {{ old('course')=='BPP' ? 'selected' : '' }}>BPP</option>
                                <option value="BPM" {{ old('course')=='BPM' ? 'selected' : '' }}>BPM</option>
                                <option value="IPD" {{ old('course')=='IPD' ? 'selected' : '' }}>IPD</option>
                                <option value="ISK" {{ old('course')=='ISK' ? 'selected' : '' }}>ISK</option>
                                <option value="CTP" {{ old('course')=='CTP' ? 'selected' : '' }}>CTP</option>
                                <option value="HSK" {{ old('course')=='HSK' ? 'selected' : '' }}>HSK</option>
                                <option value="HBP" {{ old('course')=='HBP' ? 'selected' : '' }}>HBP</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <label for="kohort" class="block text-sm font-medium text-gray-700">Tahun Kemasukan</label>
                            <input id="kohort" name="kohort" type="text"
                                value="{{ old('kohort') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
                        </div>

                        <div class="flex justify-between mt-8">
                            <a href="{{ url('/student') }}" class="inline-block px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md shadow-md">SUBMIT</button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Import CSV -->
            <div class="mt-6 p-6 bg-white rounded-lg shadow">
                <h3 class="font-semibold mb-3">Import dari CSV</h3>

                @if(session('import_errors'))
                    <div class="mb-4 rounded-md bg-yellow-50 border border-yellow-200 p-3 text-sm text-yellow-800">
                        <strong class="block font-semibold">Beberapa baris gagal diimport:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach(session('import_errors') as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center gap-3">
                        <input type="file" name="csv_file" accept=".csv" required class="block" />
                        <button type="submit" class="inline-block px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Import File</button>
                    </div>
                </form>
            </div>

@endsection