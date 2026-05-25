@props([
    'colspan' => 1,
    'icon' => 'icofont-search-1',
    'message' => 'No records found.',
    'hint' => null,
])
<tr>
    <td colspan="{{ (int) $colspan }}" class="p-0 border-0">
        <div class="tc-admin-datatable__empty">
            <i class="icofont {{ $icon }}" aria-hidden="true"></i>
            <p class="mb-0">{{ $message }}</p>
            @if (filled($hint))
                <p class="small text-muted mb-0 mt-1">{{ $hint }}</p>
            @endif
        </div>
    </td>
</tr>
