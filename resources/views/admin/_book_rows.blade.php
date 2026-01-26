@forelse($books as $i => $book)
    @php $status = strtolower($book->status ?? ''); @endphp
    <tr id="book-row-{{ $book->id }}" class="border-t book-row
        @if($status === 'borrowed') bg-yellow-200 hover:bg-yellow-100
        @elseif(in_array($status, ['lost','damaged'])) bg-red-600 text-white
        @else bg-white
        @endif
    ">
        <td class="py-3 px-4 text-center">{{ ($books->firstItem() ?? 0) + $i }}</td>
        <td class="py-3 px-4 font-mono text-sm whitespace-nowrap book-col-id">{{ $book->barcode ?? $book->book_id ?? $book->id }}</td>
        <td class="py-3 px-4 book-col-title">{{ $book->title ?? $book->name }}</td>
        <td class="py-3 px-4 font-semibold text-center book-col-status">
            <span class="@if(in_array($status, ['lost','damaged'])) text-white @endif">{{ $book->status }}</span>
        </td>
        <td class="py-3 px-4 text-center text-xs">
            <a href="{{ route('book.edit', $book->id) }}" class="block leading-tight @if(in_array($status, ['lost','damaged'])) text-white/90 hover:text-white @else text-blue-600 hover:text-blue-800 @endif">update</a>
            <form action="{{ route('book.destroy', $book->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Padam rekod?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="block leading-tight mt-1 @if(in_array($status, ['lost','damaged'])) text-white/90 hover:text-white @else text-red-600 hover:text-red-800 @endif">delete</button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="p-4 text-center text-sm text-gray-500">Tiada rekod buku.</td>
    </tr>
@endforelse

<tr id="books-pagination-row">
    <td colspan="5" class="p-4">
        {{ $books->links() }}
    </td>
</tr>
