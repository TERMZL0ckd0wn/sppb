@forelse($teachers as $i => $t)
    <tr class="@if($i%2==0) bg-white @else bg-gray-50 @endif">
        <td class="p-2 border">{{ ($teachers->firstItem() ?? 0) + $i }}</td>
        <td class="p-2 border whitespace-nowrap teacher-col-id">{{ $t->no_matrik ?? $t->staff_id ?? $t->id }}</td>
        <td class="p-2 border teacher-col-name">{{ $t->name }}</td>
        <td class="p-2 border whitespace-nowrap teacher-col-email">{{ $t->email }}</td>
        <td class="p-2 border whitespace-nowrap teacher-col-phone">{{ $t->phone ?? '-' }}</td>
        <td class="p-2 border teacher-col-department">{{ $t->department ?? '-' }}</td>
        <td class="p-2 border">
            <a href="{{ url('/teacher/'.$t->id.'/edit') }}" class="text-indigo-600 hover:underline">EDIT</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="p-4 text-center text-sm text-gray-500">Tiada rekod pensyarah.</td>
    </tr>
@endforelse

<tr id="teachers-pagination-row">
    <td colspan="7" class="p-4">
        {{ $teachers->links() }}
    </td>
</tr>
