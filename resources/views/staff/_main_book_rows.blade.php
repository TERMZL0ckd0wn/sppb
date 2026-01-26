@forelse($books as $i => $book)
    @php
        $status = strtolower($book->status ?? 'tersedia');
        $badgeClass = $status === 'dipinjam' ? 'bg-orange-100 text-orange-800' :
                      (($status === 'hilang' || $status === 'rosak') ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800');
    @endphp
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ ($books->firstItem() ?? 0) + $i }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $book->barcode ?? $book->book_id ?? $book->id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $book->title ?? $book->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">{{ ucfirst($status) }}</span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tiada rekod buku.</td>
    </tr>
@endforelse

<tr id="main-books-pagination-row">
    <td colspan="4" class="px-6 py-4">
        {{ $books->links() }}
    </td>
</tr>
