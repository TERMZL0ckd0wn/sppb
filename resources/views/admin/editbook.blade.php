@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

<div class="text-center mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Kemaskini Buku</h1>
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

        <form action="{{ route('book.update', $book->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- ID / Barcode -->
            <div class="form-row">
                <label for="barcode" class="block text-sm font-medium text-gray-700">ID / Barcode</label>
                <input id="barcode" name="barcode" type="text" required
                    value="{{ old('barcode', $book->barcode) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <!-- Title -->
            <div class="form-row">
                <label for="title" class="block text-sm font-medium text-gray-700">Tajuk Buku</label>
                <input id="title" name="title" type="text" required
                    value="{{ old('title', $book->title) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <!-- Author -->
            <div class="form-row">
                <label for="author" class="block text-sm font-medium text-gray-700">Penulis</label>
                <input id="author" name="author" type="text"
                    value="{{ old('author', $book->author) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <!-- Year -->
            <div class="form-row">
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun Terbitan</label>
                <input id="year" name="year" type="number" min="0"
                    value="{{ old('year', $book->year) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2" />
            </div>

            <!-- Status -->
            <div class="form-row">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2">
                    @php $st = old('status', $book->status ?? 'available'); @endphp
                    <option value="available" {{ $st === 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="borrowed"  {{ $st === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="lost"      {{ $st === 'lost' ? 'selected' : '' }}>Hilang</option>
                    <option value="damaged"   {{ $st === 'damaged' ? 'selected' : '' }}>Rosak</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between mt-6">

                <!-- Left side: cancel + save -->
                <div class="space-x-2">
                    <a href="{{ route('book.index') }}"
                    class="inline-block px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-block px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
            </form> <!-- <-- CLOSE UPDATE FORM -->

            <!-- Delete form OUTSIDE the update form -->
            <form action="{{ route('book.destroy', $book->id) }}"
                method="POST"
                onsubmit="return confirm('Padam buku ini?');"
                class="mt-4">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="inline-block px-3 py-2 rounded-md bg-red-600 text-white text-xs hover:bg-red-700">
                    Padam
                </button>
            </form>
        </form>
    </div>
</div>

@endsection