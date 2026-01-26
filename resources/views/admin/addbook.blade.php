@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Buku</h1>
            </div>

            <div class="mb-4">
                <button type="button" onclick="history.back()" class="inline-flex items-center px-3 py-2 bg-white/20 text-gray-700 rounded-md hover:bg-white/30 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
            </div>

            <div class="bordered-section p-8">
                <div class="form-container">
                    <!-- Single book add form -->
                    <form action="{{ route('book.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="form-row">
                            <label for="barcode">Barcode:</label>
                            <input type="text" id="barcode" name="barcode" value="" required class="w-full p-2 border rounded">
                        </div>

                        <div class="form-row">
                            <label for="title">Tajuk Buku:</label>
                            <input type="text" id="title" name="title" value="" required class="w-full p-2 border rounded">
                        </div>

                        <div class="form-row">
                            <label for="author">Penulis:</label>
                            <input type="text" id="author" name="author" value="" class="w-full p-2 border rounded">
                        </div>

                        <div class="form-row">
                            <label for="year">Tahun Terbitan:</label>
                            <input type="number" id="year" name="year" value="" class="w-full p-2 border rounded">
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-8 rounded-md shadow-md transition duration-150">
                                SUBMIT
                            </button>
                        </div>
                    </form>

                    <hr class="my-6">
                    
                    <!-- Import CSV form -->

                    
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

                        <form action="{{ route('book.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex items-center gap-3">
                                <input type="file" name="csv_file" accept=".csv" required class="block" />
                                <button type="submit" class="inline-block px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Import File</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

@endsection