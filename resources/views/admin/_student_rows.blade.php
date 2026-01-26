@forelse($students as $i => $s)
    <tr class="@if($i%2==0) bg-white @else bg-gray-50 @endif">
        <td class="p-2 border">{{ ($students->firstItem() ?? 0) + $i }}</td>
        <td class="p-2 border whitespace-nowrap student-col-id">{{ $s->no_matrik ?? $s->student_id }}</td>
        <td class="p-2 border student-col-name">{{ $s->name }}</td>
        <td class="p-2 border whitespace-nowrap student-col-email">{{ $s->email }}</td>
        <td class="p-2 border whitespace-nowrap student-col-phone">{{ $s->phone ?? '-' }}</td>
        <td class="p-2 border student-col-course">{{ $s->course ?? '-' }}</td>
        <td class="p-2 border student-col-kohort">{{ $s->kohort ?? '-' }}</td>
        <td class="p-2 border">
            <a href="{{ url('/student/'.$s->id.'/edit') }}" class="text-indigo-600 hover:underline">EDIT</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="p-4 text-center text-sm text-gray-500">Tiada rekod pelajar.</td>
    </tr>
@endforelse

<!-- pagination links (rendered server-side) -->
<tr id="students-pagination-row">
    <td colspan="8" class="p-4">
        {{ $students->links() }}
    </td>
</tr>
